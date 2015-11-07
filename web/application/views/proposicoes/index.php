<?php $this->load->view('header'); ?>
<div class="container" role="main">
    <h2>Proposições disponíveis</h2>

    <?php if($is_admin): ?>
        <a href="<?= site_url('/proposicoes/pesquisar') ?>" class="btn btn-default">
            Adicionar nova
        </a>
    <?php endif; ?>

    <ul>
        <?php foreach ($proposicoes as $proposicao) : ?>
            <li>
                <h3><?php echo $proposicao->nome ."\n"; ?></h3>
                <div class="btn btn-info" data-toggle="modal" data-target="#novoProjetoModal">Publicar</div>
                <p>
                    <?php echo $proposicao->ementa ."\n"; ?>
                </p>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php $this->load->view('footer.php');
