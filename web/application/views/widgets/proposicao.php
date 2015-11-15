<h3>
<a href="<?= $proposicao->link ?>" target="_blank" data-toggle="tooltip" title="Inteiro Teor">
    <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
</a>
<?= $proposicao->nome ?>
</h3>

<p>
    Ementa: <?= $proposicao->ementa ?>
</p>
<p>
    <?php if(!empty($proposicao->explicacao_ementa)): ?>
        Explicação: <?= $proposicao->explicacao_ementa ?>
    <?php endif; ?>
</p>
<p><strong>Tema:</strong> <?= $proposicao->tema ?></p>
<p>Apresentada em <strong><?= date('d/m/Y', strtotime($proposicao->data_apresentacao)) ?></strong> por <strong><?= $proposicao->autor ?></strong></p>
<p>Regime de tramitação <strong><?= $proposicao->regime_tramitacao ?></strong></p>
<p>Situação: <strong><?= $proposicao->situacao_camara ?></strong>. Apreciação: <strong><?= $proposicao->apreciacao ?></strong></p>