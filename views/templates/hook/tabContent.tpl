<form method="post" action="{$link->getModuleLink('nutriscoreplus','test')}" name="formNutriscore" id="formNutriscore">
    {foreach from=$attributs item=$attribut}
        {if $attribut["active"] == 1}
            <div class="form-group">
            <label class="form-control-label" for="{$attribut["id_attribut_nutriscore"]}">{$attribut["attribut_nutriscore_name"]}</label>
            <input type="text" class="form-control" id="{$attribut["id_attribut_nutriscore"]}" name="{$attribut["id_attribut_nutriscore"]}"/>
            <input type="hidden" value="{$product}" name="product"/>
            </div>
            <br />
        {/if}
    {/foreach}
    
        
    <button class="btn btn-primary" name="submitForm" type="submit">Save</button>
</form>