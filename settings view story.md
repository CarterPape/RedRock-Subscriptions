# Settings pages

When the user sends the server a request for the settings page, a SettingsViewController instance responds to the request (as emplaced by the SettingsService).

The SettingsViewController instance first handles (or delegates other objects to handle) postbacks, which might contain requests to save new settings or invoke an action.

The SettingsViewController instance then constructs a SettingsViewLoader, passing to it information that the loader uses to choose which settings subpage to load, and invokes the instance's loadSettingsView.

## Subviews and tab views

The SettingsViewController instance passes the $REQUEST variable to the  SettingsViewLoader class when constructing an instance as an argument named $settingsRequest. Although $REQUEST is a global variable, should the SettingsViewController want to load a view based on information other than what is provided in the $REQUEST variable, it can pass to the SettingsViewLoader alternative request information.

The SettingsViewLoader instance determines which tab view and subpage to load based on the contents of $settingsRequest. It then constructs a SettingsView instance, passing to it parameters including an instance of the SettingsSubpageView to render and the SettingsTabView instance (if any) to show.

From within its rendering method, the SettingsView instance renders the SettingsSubpageView and SettingsTabView instances that the SettingsViewLoader provided it at the time of construction.

## Actions

SettingsService emplaces all the action responders by looking for all the subclasses of whatever action responder class. so adding another subclass automatically registers it with SettingsService, and the template, which cannot so easily determine how to automatically integrate it, can just have the by-tag reference in the action input.

## Form certificates (i.e. nonces)

A SettingsSubpageView instance may include an array of FormCertificateView instances that the view gets at construction time by creating and invoking a transient instance of a FormCertificateViewFactory. The settings subpage's template file determines where these form certificate views go.

For example, a settings subpage view with a button to reset the whole plugin and a button to save 

A controller or delegate should maintain a list of actions available on each subpage along with the object and method that should respond to the user invoking that action. The view itself should definitely _not_ maintain the information about what handles what action (think of how Xcode does this in xib files); a controller should.

A FormCertificateView is not literally a bean, but since it is a view, it cannot generate the nonce form field that it holds. This is instead passed to it at the time of construction. A FormCertificateView instance simply holds the nonce element and renders it when asked.

FormCertificateViewFactory instances create FormCertificateView instances by taking as a constructor parameter the SettingsSubpageView instance where the certificate view will go and using the name of the action taken on that subpage 

It is a lightweight object that uses PHP's ReflectionClass to determine the name of the action that the SettingsSubpage accepts (as determined by the controller of the subpage)