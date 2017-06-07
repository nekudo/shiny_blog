# ShinyBlog

A simple, lightweight and easy to use Blog/CMS application.

ShinyBlog is a very simple and easy to understand Blog/CMS solution. Create new blog-articles by just uploading
a markdown file to your server. No overhead. This project was build with simplicity in mind. I tried to use as little
dependencies as possible and keep the code as clean as possible to build a lightweight alternative to all the bloatware
out there.

## Features

* __Markdown based:__ Article and page contents can be written using markdown or [markdown-extra](https://michelf.ca/projects/php-markdown/extra/) syntax.
* __Theme support:__ Create your own theme to adjust the layout of your website.
* __Category support:__ Blog articles can be sorted into various categories.
* __RSS feeds:__ Separate RSS feeds for all articles and article-categories are available.
* __Pagination:__ Set how many articles you want to show per page.
* __Basic SEO support:__ Title-Tags,Meta-Description, and index/follow stuff can be adjusted via config-file.
* __XML sitemap:__ Sitemap of all articles and pages is automatically generated.
* __Excerpts:__ Using a _read-more_ tag in your articles you can define the excerpt to appear on the blog-page.
* __Clean Code:__ Well documented, PSR-0 and PSR-2 compatible PHP code.

## Demo

My website [nekudo.com](https://nekudo.com) is based on this application so you can consider it a demo.

## Installation

### Requirements

* PHP >= 7.0
* PHP Modules DOM, SimpleXML, XML and MBSTRING

On Debian e.g. installing `php7.0 php7.0-xml php7.0-mbstring` should suffice.

### Installation procedure

1. Clone or download repository to your server.
2. Rename `/src/config.sample.php` to `/src/config.php`.

## How to use

### Adjusting configuration

The first step you should do after installation is to adjust the config file. This file holds all information
about urls, meta-tags e.g. and should be adjusted to your requirements.
 
The configuration file can be found in: `/src/config.php`

### Adding contents

To add new contents you just need to place a new markdown file into the `/contents/articles` or
`/contents/pages` pages folder. New articles will automatically show up in the blog. New pages also need a new
route to be defined in the config file.

Every content file needs a _meta-block_ and a _content-block_ separated by the followin code:

`::METAEND::`

An article e.g. look like this:

```
{
  "title":"Hello World!",
  "metaTitle": "Hello World!",
  "description": "Hello Word. A ShinyBlog dummy blog article.",
  "date" : "2016-01-23",
  "slug" : "hello-world",
  "author" : "Simon", 
  "categories":"News"
}

::METAEND::

Sit by the fire. Wake up human for food at 4am chase dog then...
```

Please see the dummy markdown files for a more detailed example.

### Styling

All the layout is done by the _theme_. Themes live in the `/themes` folder.

The best practice to adjust the stying is to copy the _kiss_ theme into your own folder and than adjust it to
whatever you like. Don't forget to set the config to use you newly created theme!

## Local testing

From your `shiny_blog`-folder (the one containing `index.php`) run:

`php -S localhost:8000`

Point your browser to `http://localhost:8000`

## Thanks to / Libs used

* [FastRoute](https://github.com/nikic/FastRoute)
* [Parsedown](https://github.com/erusev/parsedown)
* [Parsedown Extra](https://github.com/erusev/parsedown-extra)

## License

The MIT license