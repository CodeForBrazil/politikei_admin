<?php $this->load->view('header'); ?>
<div class="container" role="main">
    <h2>Proposições disponíveis</h2>
    <?php if($is_admin): ?>
    <a href="<?= site_url('/users') ?>" class="btn btn-default">
        Usuários
    </a>
    <a href="<?= site_url('/proposicoes/pesquisar') ?>" class="btn btn-default">
        Adicionar nova
    </a>
    <?php endif; ?>

    <ul>
        <?php foreach ($proposicoes as $proposicao) : ?>
            <li>
                <div class="bs-callout bs-callout-info">
                    <?= $this->load->view('widgets/proposicao', ['proposicao' => $proposicao], true); ?>

                    <?php if($proposicao->is_reservada()): ?>
                    <p>Proposição reservada por: <?= $proposicao->get_colaborador()->get_name_or_email() ?></p>
                    <?php endif; ?>

                    <div class="btn-group">
                        <?php if($is_admin): ?>
                            <?php if($proposicao->is_ativa()): ?>
                            <a href="<?= site_url('/proposicoes/desativar/'.$proposicao->id) ?>" class="btn btn-danger btn-sm post-link" data-confirm="Confirma que deseja desativar esta proposição?">
                                Desativar
                            </a>
                            <?php else: ?>
                            <a href="<?= site_url('/proposicoes/ativar/'.$proposicao->id) ?>" class="btn btn-success btn-sm post-link" data-confirm="Confirma que deseja ativar esta proposição?">
                                Ativar
                            </a>
                            <?php endif; ?>
                            <?php if($proposicao->pode_excluir($errors)): ?>
                                <a href="<?= site_url('/proposicoes/excluir/'.$proposicao->id) ?>" class="btn btn-danger btn-sm post-link" data-confirm="Confirma que deseja excluir esta proposição?">
                                    Excluir
                                </a>
                            <?php endif; ?>    
                        <?php endif; ?>
                        <a href="<?= site_url('/proposicoes/resumo/'.$proposicao->id) ?>" class="btn btn-default btn-sm">
                            Resumo
                        </a>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
    </ul>
</div>
<?php $this->load->view('footer.php');
