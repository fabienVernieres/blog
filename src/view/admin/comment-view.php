<?php require 'header.php'; ?>

<?php if (empty($object1)) : ?>
<div class="alert alert-success mt-3" role="alert">Aucun commentaire à vérifié</div>
<?php else : ?>
<div class="alert alert-danger mt-3" role="alert">Commentaires en attente de validation</div>
<?php endif; ?>

<table data-toggle="table" data-pagination="true" data-search="true">
    <thead>
        <tr class="bg-dark text-light">
            <th data-field="id" data-sortable="true">ID</th>
            <th data-field="titre" data-sortable="true">Commentaire</th>
            <th data-field="date" data-sortable="false">Auteur</th>
            <th>Article</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($object1 as $comment) : ?>
        <tr>
            <td><?= $comment->id ?></td>
            <td><?= $comment->title . '<br>' . $comment->text ?></td>
            <td><?= $comment->author ?></td>
            <td><a href="<?= ROOT ?><?= $comment->articleSlug ?>">
                    <?= $comment->articleTitle ?></a></td>
            <td>


                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#modalValid<?= $comment->id ?>">
                    valider
                </button>
                <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                    data-target="#modalDelete<?= $comment->id ?>">
                    X
                </button>
                </p>
                </div>

                <div class="modal fade" id="modalValid<?= $comment->id ?>" tabindex="-1" role="dialog"
                    aria-labelledby="modalValid<?= $comment->id ?>Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title text-light" id="modalValid<?= $comment->id ?>Label">Confirmer la
                                    validation
                                    du
                                    commentaire?</h5>
                            </div>
                            <div class="modal-body">
                                <h5><?= $comment->title ?></h5>
                                <p><em><?= $comment->text ?></em></p>
                                <p>Pour l'article : <?= $comment->articleTitle ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <a href="<?= ROOT ?>admin/valid/<?= $comment->slug ?>" class="btn btn-primary"
                                    role="button">Confirmer</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalDelete<?= $comment->id ?>" tabindex="-1" role="dialog"
                    aria-labelledby="modalDelete<?= $comment->id ?>Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title text-light" id="modalDelete<?= $comment->id ?>Label">Confirmer la
                                    suppression
                                    du
                                    commentaire?</h5>
                            </div>
                            <div class="modal-body">
                                <h5><?= $comment->title ?></h5>
                                <p><em><?= $comment->text ?></em></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <a href="<?= ROOT ?>admin/delete/<?= $comment->slug ?>" class="btn btn-primary"
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