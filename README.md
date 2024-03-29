<!--
---
author: mos
revision:
    "2023-03-26": "(C, mos) Upgraded to Symfony version 7.0."
    "2023-03-28": "(B, mos) Work through and very updated."
    "2022-03-27": "(A, mos) First release."
---
-->

![Symfony image](public/img/1.png)

Get going with Symfony
====================

This exercise will help you create a web application/service using a Symfony installation.

You will add a controller that serves responses as web pages using the template engine Twig. You will also create a controller that provides a REST API with JSON responses.


git clone https://github.com/airhelios/mvc

Go to the report and start the app with:

```
# You are in the report/ directory
php -S localhost:8888 -t public
```

<!--
TODO

* Add a logger and use it to debug

* Try using the Symfony demo application? https://github.com/symfony/demo

* Add image with encore and use through asset()?



# 2023

* How to send arguments to a route
    * `/api/lucky/number/1/100`
    * And through the querystring
    * How to verify its type
* Render form using Symfony, post 1 to 100

* Send object to twig and use methods/properties to print out details of the object.

-->

* [Documentation](#documentation)
* [Video](#video)
* [Prerequisites](#prerequisites)
* [Prepare](#prepare)
* [Install the project skeleton](#install-the-project-skeleton)
* [Run your app](#run-your-app)
* [Publish the app to the student server](#publish-the-app-to-the-student-server)
* [Create a home page using a controller](#create-a-home-page-using-a-controller)
    * [Add a controller and a route](#add-a-controller-and-a-route)
    * [The controller class](#the-controller-class)
    * [Use bin/console debug:router](#use-binconsole-debugrouter)
    * [Visit the route](#visit-the-route)
    * [Add another route](#add-another-route)
* [Symfony bin/console](#symfony-binconsole)
* [The controller](#the-controller)
* [Add a JSON route](#add-a-JSON-route)
    * [Use a JsonResponse](#use-a-JsonResponse)
    * [JSON pretty print](#json-pretty-print)
* [Add a new controller](#add-a-new-controller)
* [Render a web page using a template](#render-a-web-page-using-a-template)
    * [Install Twig package](#install-twig-package)
    * [Create a controller using twig](#create-a-controller-using-twig)
    * [Create a template file](#create-a-template-file)
    * [Extend a base template](#extend-a-base-template)
* [Include CSS and JavaScript in the base template](#include-CSS-and-JavaScript-in-the-base-template)
    * [Install Encore](#install-Encore)
    * [Disable bootstrap.js](#disable-bootstrapjs)
    * [Setup the project using Encore](#setup-the-project-using-Encore)
    * [Add style](#add-style)
    * [Add JavaScript](#add-JavaScript)
* [Navigate between pages](#navigate-between-pages)
    * [Add routes to home, about](#add-routes-to-home,-about)
    * [Add a navbar](#add-a-navbar)
* [Show images](#show-images)
    * [Public image as an asset](#public-image-as-an-asset)
    * [Add a favicon](#add-a-favicon)
    * [Add a header image](#add-a-header-image)
    * [Add a background image through CSS and Encore](#add-a-background-image-through-CSS-and-Encore)
    * [Reference built asset images from templates](#reference-built-asset-images-from-templates)
* [Where to go from here?](#where-to-go-from-here?)
