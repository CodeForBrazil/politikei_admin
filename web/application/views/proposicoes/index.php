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
                <p>
                    <?php echo $proposicao->ementa ."\n"; ?>
                </p>
                <?php if($is_admin && $proposicao->is_ativa()){ ?>
                <a href="<?= site_url('/proposicoes/desativar/'.$proposicao->id) ?>" class="btn btn-danger btn-sm post-link" data-confirm="Confirma que deseja desativar esta proposição?">
                    Desativar
                </a>
                <?php } else if($is_admin){ ?>
                <a href="<?= site_url('/proposicoes/ativar/'.$proposicao->id) ?>" class="btn btn-success btn-sm post-link" data-confirm="Confirma que deseja ativar esta proposição?">
                    Ativar
                </a>
                <?php } ?>
            </li>
            <?php endforeach; ?>
    </ul>
</div>
<?php $this->load->view('footer.php');
