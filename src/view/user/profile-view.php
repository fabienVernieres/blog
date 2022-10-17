<div class="pt-4 bg-primary pb-3">
    <div class="container">
        <div class="col-xl-12 col-xxl-12 px-2 py-2">
            <div class="row align-items-center g-lg-5 py-5">
                <div class="col-lg-7 text-center text-lg-start text-light">
                    <h1 class="display-4 fw-bold lh-1 mb-3"><?= $pageTitle ?></h1>
                    <p class="col-lg-10 fs-4"><?= $object1->description ?></p>

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

        <?php if (!empty($object2)) : ?>
        <h5 class="text-light mt-3 mb-3">Mes liens internet</h5>
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