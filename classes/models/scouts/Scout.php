<?php

namespace RedRock\Subscriptions;

/*
    A Scout retrieves information. Usually, a Scout retrieves information from WordPress, a framework that I feel like should organize in an object oriented way with models and views and such but instead exposes functions for retrieving and manipulating information.
    
    In some circumstances, a Scout looks for information on behalf of another object.
    
    A Scout's sole purpose in life is to retrieve and package information. They are lightweight and disposable. They do not modify information; they do not interpret information (hence why they are not called Journalists or Reporters). They find and present information.
*/

abstract class Scout {
    
}
