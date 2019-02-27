<?php

namespace spec\drupol\htmltag;

use drupol\htmltag\HtmlBuilder;
use PhpSpec\ObjectBehavior;

class HtmlBuilderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(HtmlBuilder::class);
    }

    public function it_should_create_html()
    {
        $this
            ->c('comment1')
            ->c()
            ->p(['class' => ['paragraph']], 'content')
            ->c('comment2')
            ->div(['class' => 'container'], 'this is a simple div')
            ->c('comment3')
            ->_()
            ->c('comment4')
            ->a()
            ->c('comment5')
            ->span(['class' => 'link'], 'Link content')
            ->c('comment6')
            ->_()
            ->c('comment7')
            ->div(['class' => 'Unsecure "classes"'], 'Unsecure <a href="#">content</a>')
            ->c('comment8')
            ->_()
            ->c('comment9')
            ->__toString()
            ->shouldReturn('<!--comment1--><p class="paragraph">content<!--comment2--><div class="container">this is a simple div<!--comment3--></div></p><!--comment4--><a><!--comment5--><span class="link">Link content<!--comment6--></span></a><!--comment7--><div class="Unsecure &quot;classes&quot;">Unsecure &lt;a href=&quot;#&quot;&gt;content&lt;/a&gt;<!--comment8--></div><!--comment9-->');
    }
}
