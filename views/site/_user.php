<div class="page-header">
    <h1>Réalisations</h1>
</div>

<div class="row ">
    
    <div class="col-md-12">
        <ul>
            <?php foreach ($realisations as $realisation): ?>
            <li>
                <pre><?= var_dump($realisation->toArray()) ?></pre>
            </li>
            <?php endforeach; ?>
        </ul>
    </div><!-- .row -->
</div>