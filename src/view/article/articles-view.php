<div class="pt-4 bg-primary pb-3">
    <div class="container">
        <h1 class="text-light"><?= $pageTitle ?></h1>
    </div>
</div>

<div class="pt-4 bg-light pb-5">

    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
            <?php
            foreach ($object1 as $article) : ?>
            <div class="col">
                <article class="card">
                    <?php if (!empty($article->image)) : ?>
                    <a href="<?= ROOT ?><?= $article->slug ?>">
                        <img src="<?= ROOT ?>public/upload/<?= $article->image ?>" class="card-img-top">
                    </a>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="<?= ROOT ?><?= $article->slug ?>" class="text-body text-decoration-none">
                                <?= $article->title ?></a>
                        </h5>
                        <p class="card-text"><?= $article->description ?></p>
                        <p class="card-text"><small class="text-muted"><?= $article->updateDate ?></small></p>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        </div>

        <nav class="pt-3 pb-3">
            <ul class="pagination pagination-lg">
                <li class="page-item"><a class="page-link" href="<?= ROOT ?>list">1</a></li>
                <?php for ($i = 0; $i < $object2; $i++) : ?>
                <li class="page-item"><a class="page-link" href="<?= ROOT ?>list/page/<?= $i + 2 ?>"><?= $i + 2 ?></a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</div>