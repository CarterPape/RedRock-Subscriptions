<?php

namespace RedRock\Subscriptions;

/*
    WHAT IT IS
    
    A ContentProtectionService instance is a service. It is reponsible for protecting content on the website. The service protects content by withholding it from the user unless the service can prove the user may access it.
    
    Part of protecting content is replacing it with marketing material when it is withheld and notifying the user of the number of free articles left.
    
    
    HOW IT WORKS - subject to change
    
    A ContentProtectionService instance is invoked whenever the "the_content" filter is invoked, which, from my understanding, happens whenever a post is being accessed for display purposes. **I need to investigate this further.**
    
    When invoked, the service determines whether it needs to filter the content
    
    just fucking treat bots as bots, man...
        ø change the scout behavior to just look at user agents
    
    
    **DELEGATED BEHAVIORS**
    
    This service exposes a [view manager]? that the theme (which is loaded after the plugin) can invoke, passing to it custom subclasses of the base view classes.
    
    These base view classes are non-abstract and have boilerplate stuff on them. One such view: The blurb view (with free quota and account information in it). The other main one: The forbidding view (which truncates the story and adds the tear-off view at the bottom, which contains a paywall view, which in a sublcass could include the marketing blurb and subscription options but the boilerplate just says "you need a subscription, bud").
        o make a controller class file
        o make a member instance of the controller here
        o make a QuotaBlurbView that has a template with a bunch of conditionals that loads sentences based on the combination of blurbs to provide. Conceptually, the view is just the stuff inside the blurb bubble.
        o make a ForbiddingView that truncates, has the tear-off, and has a boilerplate PaywallView
        ø make the RedRock\PaywallView subclass
            o make sure it's properly subclassed
    
    Such a custom subclass (the QuotaBlurbView) can give context-aware and application-specific verbiage to web clients about the reason that content is forbidden, about why the content is restricted, about how many reads are left, and so on.
        o make this subclass in RedRock
        o quickly hook up this subclass in RedRock (conditionally if plugin is loaded)
        o 
    
    HERE, THE INSTANCE VARIABLES SHOULD BE PRIVATE AND TYPE HINTING SHOULD BE USED IN THE setView FUNCTIONS TO ENSURE THAT THE VIEWS ARE CORRECTLY SUBLCASSED.
    
    Maybe this is also the place to expose a way for the theme to set the free quota—no no no, the number of monthly free articles should be a setting of the plugin.
*/

class ContentProtectionService extends Service {
    private $contentAccessContext   = null;
    private $accessContextResolver  = null;
    private $contentViewFactory     = null;
    private $filterPredicateList    = array();
    
    public function _construct() {
        $contentViewFactory = new ProtectedContentViewFactory;
    }
    
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
