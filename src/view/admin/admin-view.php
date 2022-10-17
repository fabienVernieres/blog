<?php require 'header.php'; ?>

<p class="text-start fs-5">
    <a href="<?= ROOT ?>form/add/article">Ajouter un article</a>
</p>

<?php if (!empty($object1)) : ?>
<h5>Liste de vos articles</h5>
<?php endif; ?>

<table data-toggle="table" data-pagination="true" data-search="true">
    <thead>
        <tr class="bg-dark text-light">
            <th data-field="id" data-sortable="true">ID</th>
            <th data-field="titre" data-sortable="true">Titre</th>
            <th data-field="date" data-sortable="false">Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($object1 as $article) : ?>
        <tr>
            <td><?= $article->id ?></td>
            <td><a href="<?= ROOT ?><?= $article->slug ?>"><?= $article->title ?></a>
            </td>
            <td class="text-secondary"><?= $article->updateDate ?></td>
            <td><a href="<?= ROOT ?>form/update/<?= $article->slug ?>" class="btn btn-primary btn-sm">Modifier</a>

                <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                    data-target="#modalDelete<?= $article->id ?>">
                    X
                </button>
                <div class="modal fade" id="modalDelete<?= $article->id ?>" tabindex="-1" role="dialog"
                    aria-labelledby="modalDelete<?= $article->id ?>Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalDelete<?= $article->id ?>Label">Confirmer la
                                    suppression définitive
                                    du post?</h5>
                            </div>
                            <div class="modal-body">
                                <?= $article->title ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <a href="<?= ROOT ?>admin/delete/<?= $article->slug ?>" class="btn btn-primary"
                                    role="button">Confirmer</a>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require 'footer.php'; ?>