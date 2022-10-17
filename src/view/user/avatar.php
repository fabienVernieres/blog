<h2 class="pt-5 border-top" id="avatar">Votre avatar</h2>

<?php if (empty($object2)) : ?>
<div class="alert alert-success mt-3" role="alert">Aucune image</div>
<form action="<?= ROOT ?>form/addImage" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="mb-3 col-md-5">
            <label for="fileToUpload" class="form-label">Ajouter une image</label>
            <input class="form-control" type="file" name="fileToUpload" id="fileToUpload">
        </div>
    </div>


    <div class="row">
        <div class="mb-3 col-md-5">
            <button class="btn btn-primary mt-3" type="submit">
                Valider</button>
        </div>
    </div>
</form>

<?php else : ?>

<div class="list-group mt-3">
    <div class="list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-3">
                <?= $object2->title ?>
            </h5>
        </div>
        <p>
            <img src="<?= ROOT ?>public/upload/<?= $object2->url ?>" class="img-thumbnail">
        </p>
        <p>
            <small>Posté le <?= $object2->creationDate ?></small>
        </p>

        <p>
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                data-target="#modalDelete<?= $object2->id ?>">
                supprimer
            </button>
        </p>
    </div>

    <div class="modal fade" id="modalDelete<?= $object2->id ?>" tabindex="-1" role="dialog"
        aria-labelledby="modalDelete<?= $object2->id ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-light" id="modalDelete<?= $object2->id ?>Label">Confirmer la suppression
                        de votre image?</h5>
                </div>
                <div class="modal-body">
                    <h5><?= $object2->title ?></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <a href="<?= ROOT ?>admin/delete/<?= $object2->slug ?>" class="btn btn-primary"
                        role="button">Confirmer</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>