<?php

namespace RedRock\Subscriptions;

/*
    WHAT IT IS
    
    A ContentProtectionService instance is a service. It is reponsible for protecting content on the website. The service protects content by withholding it from the user unless the service can prove the user may access it.
    
    Part of protecting content is replacing it with marketing material when it is withheld and notifying the user of the number of free articles left.
    
    
    HOW IT WORKS - subject to change
    
    A ContentProtectionService instance is invoked whenever the "the_content" filter is invoked. To ensure that the_content is only being filtered when aappropriate, the service checks that the query is the main query for the page being displayed or requested and that the current page is singular (i.e. for diplaying an individual post or page).
        
    
    **DELEGATED BEHAVIORS**
    
    This service exposes a view factory that the theme can invoke to set custom view classes, overriding the base view classes defined in this plugin.
    
    These base view classes are non-abstract and have boilerplate stuff on them. One such view: The blurb view (with free quota and account information in it). The other main one: The forbidding view (which truncates the story and adds the tear-off view at the bottom, which contains a paywall view, which in a sublcass could include the marketing blurb and subscription options, but the boilerplate just says "you need a subscription, bud").
        ø make a view factory class file
        ø define and initialize a member instance of the view factory here
        o make a QuotaBlurbView that has a template with a bunch of conditionals that loads sentences based on the combination of blurbs to provide. Conceptually, the view is just the stuff inside the blurb bubble.
        o make a ForbiddingView that truncates the post, has the tear-off, and has a boilerplate PaywallView
        ø make the RedRock\PaywallView subclass
            o make sure it's properly subclassed
    
    Such a custom subclass (the QuotaBlurbView) can give context-aware and application-specific verbiage to web clients about the reason that content is forbidden, about why the content is restricted, about how many reads are left, and so on.
        o make this subclass in RedRock
        o quickly hook up this subclass in RedRock (conditionally if plugin is loaded)
        o 
    
    Maybe this is also the place to expose a way for the theme to set the free quota—no no no, the number of monthly free articles should be a setting of the plugin.
*/

class ContentProtectionService extends Service {
    private $contentAccessContext   = null;
    private $accessContextResolver  = null;
    private $contentViewFactory     = null;
    private $filterPredicateList    = array();
    
    public function appendFilterPredicate(callable $newPredicate) {
        array_push(
            $filterPredicateList,
            $newPredicate
        );
    }
    
    public function prependFilterPredicate(callable $newPredicate) {
        array_unshift(
            $filterPredicateList,
            $newPredicate
        );
    }
    
    public function getContentViewFactory() {
        return $contentViewFactory;
    }
    
    public function emplaceCallbacks() {
        $latePriority       = 1000;
        $argumentsPassed    = 1;
        
        add_filter(
            "the_content",
            array(
                $this,
                "maybeProtectContent"
            ),
            $latePriority,
            $argumentsPassed
        );
    }
    
    private function maybeProtectContent($requestedContent) {
        if (contentShouldBeProtected()) {
            return protectContent($requestedContent);
        }
        else {
            return $requestedContent;
        }
    }
    
    private function contentShouldBeProtected() {
        // We only want to invoke all this protection shit when WordPress applies the the_content filter in preparation to show a post (or page, I guess) on the page dedicated to that post. Elsewhere, we expect the post to be partially filtered (i.e. on the front page, where the_content is sometimes requested for excerpting the article) or for the filter to be invoked for some other reason. See below for details.
        // https://pippinsplugins.com/playing-nice-with-the-content-filter/comment-page-1/
        
        return is_singular() && is_main_query();
    }
    
    private function protectContent($requestedContent) {
        $contentViewFactory = new ProtectedContentViewFactory;
        $contentAccessContext = new ContentAccessContext($requestedContent);
        
        $accessContextResolver = new AccessContextResolver(
            $contentAccessContext,
            $contentViewFactory,
            $filterPredicateList
        );
        
        $accessContextResolver->resolveAccessContext();
        
        return $contentViewFactory->fabricateView();
    }
}
