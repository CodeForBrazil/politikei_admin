<?php $this->load->view('header'); ?>
<div class="container" role="main">
    <h2>Usuários do sistema</h2>
    <a href="<?= site_url('/proposicoes') ?>" class="btn btn-default">
        Proposições
    </a>
    <ul>
        <?php foreach ($users as $user) : ?>
        <li>
            <h3><?= $user->get_name() ?> - <?= $user->get_role_desc() ?></h3>
            <p><?= $user->email ?></p>
            <?php if($user->pode_autorizar($errors)): ?>
            <a href="<?= site_url('/users/autorizar/'.$user->id) ?>" class="btn btn-primary btn-sm post-link" data-confirm="Confirma que deseja autorizar este usuário?">
                Autorizar como colaborador
            </a>
            <?php endif; ?>
            <?php if($user->pode_desautorizar($errors)): ?>
            <a href="<?= site_url('/users/desautorizar/'.$user->id) ?>" class="btn btn-danger btn-sm post-link" data-confirm="Confirma que deseja remover a permissão de colaborador este usuário?">
                Retirar autorização de colaborador
            </a>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php $this->load->view('footer.php');
