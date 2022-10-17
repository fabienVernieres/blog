<?php require 'header.php'; ?>

<?php if (empty($object1)) {
    $action = "addArticle";
    $submit = "Poster";
} else {
    $action = "updateArticle";
    $submit = "Modifier";
}
?>

<form action="<?= ROOT ?>form/<?= $action ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= (!empty($object1)) ? $object1->id : ''; ?>">
    <input type="hidden" name="slug" value="<?= (!empty($object1)) ? $object1->slug : ''; ?>">
    <input type="hidden" name="category" value="<?= (!empty($object1)) ? $object1->category : ''; ?>">
    <div class="row">
        <div class="mb-3 col-md-5">
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" name="title" maxlength="<?= SHORT_INPUT ?>"
                aria-describedby="titleHelp" value="<?= (!empty($object1)) ? $object1->title : ''; ?>">
            <div id="titleHelp" class="form-text"><?= SHORT_INPUT ?> caractères maximum</div>
        </div>
        <div class="mb-3 col-md-5">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" name="description" maxlength="<?= MEDIUM_INPUT ?>"
                aria-describedby="descriptionHelp" value="<?= (!empty($object1)) ? $object1->description : ''; ?>">
            <div id="descriptionHelp" class="form-text"><?= MEDIUM_INPUT ?> caractères maximum</div>
        </div>

        <div class="mb-3 col-md-10">
            <label for="text" class="form-label">Contenu de votre article</label>
            <textarea class="form-control" name="text" placeholder="Ecrivez votre texte ici"
                rows="10"><?= (!empty($object1)) ? $object1->text : ''; ?></textarea>
        </div>

        <div class="mb-3 col-md-10">
            <?php if (empty($object2)) : ?>
            <label for="fileToUpload" class="form-label">Ajouter une image</label>
            <input class="form-control" type="file" name="fileToUpload" id="fileToUpload">

            <?php else : ?>

            <?php foreach ($object2 as $image) : ?>
            <h5>Image liée à cette article</h5>
            <figure class="px-3 figure">
                <img src="<?= ROOT ?>public/upload/<?= $image->url ?>" class="img-thumbnail"
                    alt="Image <?= $image->title ?>">

                <button type="button" class="figure-btn btn btn-danger btn-sm" data-toggle="modal"
                    data-target="#modalDelete<?= $image->id ?>">
                    supprimer
                </button>
            </figure>


            <div class="modal fade" id="modalDelete<?= $image->id ?>" tabindex="-1" role="dialog"
                aria-labelledby="modalDelete<?= $image->id ?>Label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-light" id="modalDelete<?= $image->id ?>Label">Confirmer la
                                suppression
                                de votre image?</h5>
                        </div>
                        <div class="modal-body">
                            <h5><?= $image->title ?></h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <a href="<?= ROOT ?>admin/delete/<?= $image->slug ?>" class="btn btn-primary"
                                role="button">Confirmer</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <?php endif; ?>
        </div>

        <div class="mb-3 col-md-5">
            <label for="author" class="form-label">Auteur</label>
            <input type="text" class="form-control" name="author" maxlength="<?= SHORT_INPUT ?>"
                aria-describedby="authorHelp"
                value="<?= (!empty($object1)) ? $object1->author : $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname']; ?>">
            <div id="authorHelp" class="form-text"><?= SHORT_INPUT ?> caractères maximum</div>
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-5">
            <button type="submit" class="btn btn-primary"><?= $submit ?></button>
        </div>
    </div>
</form>

<?php require 'footer.php'; ?>