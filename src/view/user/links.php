<h2 class="pt-5 border-top" id="links">Vos liens internet</h2>

<?php if (empty($object3)) : ?>
<div class="alert alert-success mt-3" role="alert">Aucun lien enregistré</div>
<?php endif; ?>

<p class="mb-1"><a href="<?= ROOT ?>form/add/link">Ajouter un nouveau lien</a>
</p>

<table data-toggle="table" data-pagination="true" data-search="true">
    <thead>
        <tr class="bg-dark text-light">
            <th data-field="id" data-sortable="true">ID</th>
            <th data-field="titre" data-sortable="true">Titre</th>
            <th data-field="date" data-sortable="false">Lien</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($object3 as $link) : ?>
        <tr>
            <td><?= $link->id ?></td>
            <td><?= $link->title ?></td>
            <td><a href="<?= $link->url ?>" target="_blank"><?= $link->url ?></a></td>
            <td>

                <a href="<?= ROOT ?>form/update/<?= $link->slug ?>" class="btn btn-primary btn-sm">Modifier</a>
                <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                    data-target="#modalDelete<?= $link->id ?>">
                    X
                </button>

                <div class="modal fade" id="modalDelete<?= $link->id ?>" tabindex="-1" role="dialog"
                    aria-labelledby="modalDelete<?= $link->id ?>Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title text-light" id="modalDelete<?= $link->id ?>Label">
                                    Confirmer la
                                    suppression
                                    de votre lien?</h5>
                            </div>
                            <div class="modal-body">
                                <h5><?= $link->title ?></h5>
                                <p><em><?= $link->url ?></em></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <a href="<?= ROOT ?>admin/delete/<?= $link->slug ?>" class="btn btn-primary"
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