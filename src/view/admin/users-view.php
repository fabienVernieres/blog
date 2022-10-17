<?php require 'header.php'; ?>

<table data-toggle="table" data-pagination="true" data-search="true">
    <thead>
        <tr class="bg-dark text-light">
            <th data-field="id" data-sortable="true">ID</th>
            <th data-field="titre" data-sortable="true">Nom</th>
            <th data-field="date" data-sortable="false">Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($object1 as $user) : ?>
        <tr>
            <td><?= $user->id ?></td>
            <td><?= $user->lastname . ' ' . $user->firstname ?></td>
            <td><?= $user->email ?></td>
            <td>

                <?php if ($user->valid == 0) : ?>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                    data-target="#modalValid<?= $user->id ?>">
                    valider
                </button>
                <?php endif; ?>
                <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                    data-target="#modalDelete<?= $user->id ?>">
                    X
                </button>

                <div class="modal fade" id="modalValid<?= $user->id ?>" tabindex="-1" role="dialog"
                    aria-labelledby="modalValid<?= $user->id ?>Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title text-light" id="modalValid<?= $user->id ?>Label">Confirmer la
                                    validation
                                    de l'utilisateur?</h5>
                            </div>
                            <div class="modal-body">
                                <h5><?= $user->firstname . ' ' . $user->lastname ?></h5>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <a href="<?= ROOT ?>admin/validUser/<?= $user->id ?>" class="btn btn-primary"
                                    role="button">Confirmer</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalDelete<?= $user->id ?>" tabindex="-1" role="dialog"
                    aria-labelledby="modalDelete<?= $user->id ?>Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title text-light" id="modalDelete<?= $user->id ?>Label">Confirmer la
                                    suppression de
                                    l'utilisateur?</h5>
                            </div>
                            <div class="modal-body">
                                <h5><?= $user->firstname . ' ' . $user->lastname ?></h5>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <a href="<?= ROOT ?>admin/deleteUser/<?= $user->id ?>" class="btn btn-primary"
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