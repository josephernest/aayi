# aayi

**aayi** is a website analytics tool based on the idea that:

* we want the **number of unique visitors per day** (with a nice chart) and the **list of referers** who send some traffic to your website

* it should be lightweight and take < 1 minute to deploy on a new website.

Why the name **aayi**? It's *"AnAlYtIcs"* with only the vowels! 

Here is how it looks:

![](https://i.imgur.com/QDqKLHy.png)

If you're looking for more information than those (such as country, browser, screen resolution, time spent on a page, etc.), then **aayi** is not the right tool for you. Please try [Google Analytics](https://analytics.google.com), [Open Web Analytics](https://www.openwebanalytics.com/) or [Piwik](https://www.piwik.org/) instead. I personally found the two last ones [not very handy for me](http://afewthingz.com/aboutanalytics).

Why this project? After years, I've noticed that **I prefer to have few (important) information that I can consult each day in 30 seconds**, rather than lots of informations for which I would need 15 or 30 minutes per day for an in-depth analysis.

## Install

* Unzip this package into `/var/www/mywebsite/aayi` or simply do this from `/var/www/mywebsite`:

        git clone https://github.com/josephernest/aayi.git

* Give the appropriate permissions/owner if necessary with `chown www-data: aayi -R`.

* Add the following tracking code to your websites at then end of your website's main PHP file, e.g. `/var/www/mywebsite/index.php`:

        <?php include('aayi/tracker.php'); ?>

It's done! Visit at least once your website, and visit the analytics homepage: `https://example.com/aayi/`.

The **default password is `abcdef`**, you can optionally create a `config.php` with `<?php $PASSWORD = '...'; ?>`.

## Todo

* (Maybe but only if same user experience) Replace Google Charts JavaScript code by another open-source chart-generating JavaScript library?

* Some websites don't expose referer, [is there a way](https://stackoverflow.com/q/41466351/1422096) to solve this? 

## About

Author: Joseph Ernest ([@JosephErnest](https://twitter.com/JosephErnest))

Other projects: [BigPicture](http://bigpictu.re), [bigpicture.js](https://github.com/josephernest/bigpicture.js), [SamplerBox](http://www.samplerbox.org), [Void](http://www.thisisvoid.org), [TalkTalkTalk](https://github.com/josephernest/TalkTalkTalk), [bloggggg](https://github.com/josephernest/bloggggg), etc.
