<?php require 'header.php'; ?>

<?php if (empty($object1)) {
    $action = "addLink";
    $submit = "Poster";
} else {
    $action = "updateLink";
    $submit = "Modifier";
}
?>

<form action="<?= ROOT ?>form/<?= $action ?>" method="post">
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
            <label for="url" class="form-label">Url</label>
            <input type="text" class="form-control" name="url" maxlength="<?= MEDIUM_INPUT ?>"
                aria-describedby="urlHelp" placeholder="http://"
                value="<?= (!empty($object1)) ? $object1->url : ''; ?>">
            <div id="urlHelp" class="form-text"><?= MEDIUM_INPUT ?> caractères maximum</div>
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-5">
            <button type="submit" class="btn btn-primary"><?= $submit ?></button>
        </div>
    </div>
</form>

<?php require 'footer.php'; ?>