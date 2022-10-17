<?php require 'header.php'; ?>

<?php if (empty($object1)) : ?>
<div class="alert alert-success mt-3" role="alert">Aucune image</div>
<?php endif; ?>

<div class="row row-cols-1 row-cols-lg-3 g-4 mb-5">
    <?php
    foreach ($object1 as $article) : ?>
    <div class="col">
        <article class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <?= $article->title ?>
                </h5>
                <p>
                    <img src="<?= ROOT ?>public/upload/<?= $article->url ?>" class="img-thumbnail">
                </p>
                <p>
                    <small>Posté le <?= $article->creationDate ?></small>
                </p>

                <p>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                        data-target="#modalDelete<?= $article->id ?>">
                        supprimer
                    </button>
                </p>
            </div>
        </article>
    </div>

    <div class="modal fade" id="modalDelete<?= $article->id ?>" tabindex="-1" role="dialog"
        aria-labelledby="modalDelete<?= $article->id ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-light" id="modalDelete<?= $article->id ?>Label">Confirmer la suppression
                        de votre image?</h5>
                </div>
                <div class="modal-body">
                    <h5><?= $article->title ?></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <a href="<?= ROOT ?>admin/delete/<?= $article->slug ?>" class="btn btn-primary"
                        role="button">Confirmer</a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php require 'footer.php'; ?>