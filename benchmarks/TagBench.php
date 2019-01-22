<?php

declare(strict_types = 1);

namespace drupol\htmltag\benchmarks;

use drupol\htmltag\HtmlTag;

/**
 * @Groups({"Tag"})
 */
class TagBench extends AbstractBench
{
    /**
     * @Revs({1, 100, 1000})
     * @Iterations(5)
     * @Warmup(10)
     */
    public function benchTagRender()
    {
        $html = HtmlTag::tag('html', ['lang' => 'en']);

        $head = HtmlTag::tag('head');

        $title = HtmlTag::tag('title');
        $title->content(['Welcome to HTMLTag']);

        $meta1 = HtmlTag::tag('meta');
        $meta1->attr('name')->set('author');
        $meta1->attr('content')->set('Pol');

        $meta2 = HtmlTag::tag('meta');
        $meta2->attr('charset')->set('utf-8');

        $head->content($title, $meta1, $meta2);

        $body = HtmlTag::tag('body');
        $body->attr('class', 'logged-in', 'env-production', 'no-sidebar');

        $header = HtmlTag::tag('header');
        $header->attr('class', 'header f5');
        $header->attr('role', 'banner');
        $header->content('');

        $menu = HtmlTag::tag('ul');
        $menu->attr('class', ['user-nav d-flex flex-items-center', ['list-style-none']]);

        $menu_item1 = HtmlTag::tag('li');
        $menu_item1->attr('class', 'active', 'dropdown');
        $menu_item1->content('Home');

        $menu_item2 = HtmlTag::tag('li');
        $menu_item2
            ->attr('class', ['random', 'name class']);
        $menu_item2->content('Contact');

        $menu->content($menu_item1, $menu_item2);

        $title = HtmlTag::tag('h1');
        $title->attr('class')->set('title');
        $title->content(['Welcome to HTMLTag']);

        $paragraph = HtmlTag::tag('p');
        $paragraph->attr('class', 'section')->append('desc');
        $paragraph->content(['This library helps you create HTML.']);
        $paragraph->attr('class')->remove('section')->replace('desc', 'description');

        $content = HtmlTag::tag('div');
        $content->attr('class', 'main-content content', 'main', 'content');
        $content->content('Hello world!', $paragraph);

        $body->content($header, $title, $content);

        $html->content($head, $body);

        $html->render();
    }
}
