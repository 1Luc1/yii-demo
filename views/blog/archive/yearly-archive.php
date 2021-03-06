<?php

declare(strict_types=1);

/**
 * @var int $year
 * @var Post[]|\Yiisoft\Data\Reader\DataReaderInterface $items
 * @var \Yiisoft\Router\UrlGeneratorInterface $urlGenerator
 * @var \Yiisoft\View\WebView $this
 */

use App\Blog\Entity\Post;
use Yiisoft\Html\Html;

$this->setTitle("Archive for $year");

?>
<h1>Archive for <small class="text-muted"><?= $year ?></small></h1>
<div class="row">
    <div class="col-sm-8 col-md-8 col-lg-9">
        <?php
        if (count($items) > 0) {
            echo Html::p(
                sprintf('Total %d posts', count($items)),
                ['class' => 'text-muted']
            );
        } else {
            echo Html::p('No records');
        }
        $currentMonth = null;
        $monthName = '';
        /** @var Post $item */
        foreach ($items as $item) {
            $month = (int)$item->getPublishedAt()->format('m');

            if ($currentMonth !== $month) {
                $currentMonth = $month;
                $monthName = DateTime::createFromFormat('!m', (string) $month)->format('F');
                echo Html::div("{$year} {$monthName}", ['class' => 'lead']);
            }
            echo Html::openTag('div');
            echo Html::a(
                Html::encode($item->getTitle()),
                $urlGenerator->generate('blog/post', ['slug' => $item->getSlug()])
            );
            echo ' by ';
            $login = $item->getUser()->getLogin();
            echo Html::a(Html::encode($login), $urlGenerator->generate(
                'user/profile',
                ['login' => $login]
            ));
            echo Html::closeTag('div');
        }
        ?>
    </div>
    <div class="col-sm-4 col-md-4 col-lg-3"></div>
</div>
