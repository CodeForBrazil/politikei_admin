<?php $this->load->view('header'); ?>
<div class="container" role="main">
    <?php if($filtro == "todas"): ?>
        <h2>Todas as proposições</h2>
    <?php else: ?>
        <h2>Proposições disponíveis</h2>
    <?php endif; ?>

    <div class="btn-group">
        <?php if($filtro == "todas"): ?>
        <a href="<?= site_url('/proposicoes/') ?>" class="btn btn-default">
            Ver disponíveis
        </a>
        <?php else: ?>
        <a href="<?= site_url('/proposicoes?filtro=todas') ?>" class="btn btn-default">
            Ver todas
        </a>
        <?php endif; ?>
    </div>

    <div class="btn-group">

        <?php if($is_admin): ?>
        <a href="<?= site_url('/users') ?>" class="btn btn-default">
            Usuários
        </a>
        <a href="<?= site_url('/proposicoes/pesquisar') ?>" class="btn btn-default">
            Adicionar nova
        </a>
        <?php endif; ?>
    </div>

    <ul>
        <?php foreach ($proposicoes as $proposicao) : ?>
            <li>
                <div class="bs-callout bs-callout-info">
                    <?= $this->load->view('widgets/proposicao', ['proposicao' => $proposicao], true); ?>

                    
                    <div class="btn-group pull-left">
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
                            <?php if($proposicao->pode_reservar($errors)): ?>
                                <a href="<?= site_url('/proposicoes/reservar/'.$proposicao->id) ?>" class="btn btn-default btn-sm post-link" data-confirm="Confirma que deseja reservar esta proposição?">
                                    Reservar para resumo
                                </a>
                            <?php endif; ?> 
                        <?php endif; ?>
                        <a href="<?= site_url('/proposicoes/resumo/'.$proposicao->id) ?>" class="btn btn-default btn-sm">
                            Ver resumo
                        </a>
                    </div>
                    <div class="btn-group pull-right">
                        <a href="<?= $proposicao->link ?>" target="_blank" class="btn btn-default btn-sm" data-toggle="tooltip" title="Acessar Inteiro Teor">
                            <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Acessar Inteiro Teor
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </li>
            <?php endforeach; ?>
    </ul>
</div>
<?php $this->load->view('footer.php');
