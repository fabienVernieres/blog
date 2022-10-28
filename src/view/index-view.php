<div class="pt-4 bg-primary">
    <div class="container">
        <div class="col-xl-12 col-xxl-12 px-2 py-2">
            <div class="row align-items-center g-lg-5 py-5">

                <?php if (isset($session['user']['erreur'])) : ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?= $session['user']['erreur'] ?>
                </div>
                <?php unset($session['user']['erreur']); ?>
                <?php endif; ?>

                <?php if (isset($session['user']['message'])) : ?>
                <div class="alert alert-success mt-3" role="alert">
                    <?= $session['user']['message'] ?>
                </div>
                <?php unset($session['user']['message']); ?>
                <?php endif; ?>

                <div class="col-lg-7 text-center text-lg-start text-light">
                    <h1 class="display-4 fw-bold lh-1 mb-3"><?= $pageTitle ?></h1>
                    <h3 class=""><?= $object1->firstname . ' ' . $object1->lastname ?></h3>
                    <p class="col-lg-10 fs-4"><?= $object1->description ?></p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-5">
                        <a href="<?= ROOT ?>register" class="btn btn-info btn-lg px-4 me-md-2">Inscription</a>
                        <a href="#contact" class="btn btn-secondary btn-lg px-4">Contact</a>
                    </div>
                </div>

                <div class="col-md-10 mx-auto col-lg-5">

                    <?php if (!empty($object1->image)) : ?>
                    <img class="profile-img anim-opacity-0-to-1 img-fluid"
                        src="<?= ROOT ?>public/upload/<?= $object1->image ?>"
                        alt="<?= $object1->firstname . ' ' . $object1->lastname ?>">
                    <?php endif; ?>

                </div>
            </div>
        </div>

    </div>

    <div class="pt-4 bg-light pb-5">

        <div class="container">
            <h3 class="mb-1 text-primary">Mes derniers posts</h3>

            <div class="row row-cols-1 row-cols-md-3 g-4 mt-3 mb-5">

                <?php
                foreach ($object3 as $article) : ?>

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

            <h3 id="contact" class="mb-1 text-primary">Plus d'informations?</h3>

            <?php
            require 'contact-view.php';
            ?>

            <?php if (!empty($object2)) : ?>
            <h3 class="text-primary mt-3 mb-4">Mes liens internet</h3>
            <ul class="list-group list-group-horizontal mb-3">
                <?php
                    foreach ($object2 as $link) : ?>
                <li class="list-group-item list-group-item-secondary">
                    <a href="<?= $link->url ?>" target="_blank" class="text-body text-decoration-none">
                        <?= $link->title ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</div>