<?php $this->load->view('header'); ?>
    <div class="container" role="main">
        <h2>Proposições disponíveis</h2>

        <a href="<?= site_url('/welcome/pesquisar') ?>" class="btn btn-default">
            Pesquisar na câmara
        </a>

        <ul>
            <?php foreach ($proposicoes as $proposicao) : ?>
                <li>
                    <h3><?php echo $proposicao->nome ."\n"; ?></h3>
                    <div class="btn btn-info" data-toggle="modal" data-target="#novoProjetoModal">Publicar</div>
                    <p>
                        <?php echo $proposicao->txtEmenta ."\n"; ?>
                    </p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php $this->load->view('footer.php');
