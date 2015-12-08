<h3>

<?php if($proposicao->is_reservada()): ?>
	<span class="glyphicon glyphicon-record prop-reservada" aria-hidden="true"></span>
<?php elseif($proposicao->pode_reservar($errors)) : ?>
	<span class="glyphicon glyphicon-record prop-liberada" aria-hidden="true"></span>
<?php endif; ?>


<?= $proposicao->tipo_descricao.' '.$proposicao->numero.'/'.$proposicao->ano ?>

</h3>

<?php if($proposicao->is_reservada()): ?>
	<p class="prop-reservada">
        <strong>Proposição reservada por: <?= $proposicao->get_colaborador()->get_name_or_email() ?></strong>
    </p>
<?php elseif($proposicao->pode_reservar($errors)) : ?>
	<p class="prop-liberada">
        <strong>Disponível para reserva</strong>
    </p>
<?php endif; ?>

<div class="clearfix"></div>
<p>
    Ementa: <?= $proposicao->ementa ?>
</p>
<p>
    <?php if(!empty($proposicao->explicacao_ementa)): ?>
        Explicação: <?= '-'.$proposicao->explicacao_ementa.'-' ?>
    <?php endif; ?>
</p>
<p><strong>Tema:</strong> <?= $proposicao->tema ?></p>
<p>Apresentada em <strong><?= date('d/m/Y', strtotime($proposicao->data_apresentacao)) ?></strong></p>
<p>Autor: <strong><?php echo $proposicao->autor; echo empty($proposicao->autor_uf) ? '' :  ' '.$proposicao->autor_uf.'/'.$proposicao->autor_partido ?></strong></p>


<p>Regime de tramitação <strong><?= $proposicao->regime_tramitacao ?></strong></p>
<p>Situação: <strong><?= $proposicao->situacao_camara ?></strong>. Apreciação: <strong><?= $proposicao->apreciacao ?></strong></p>