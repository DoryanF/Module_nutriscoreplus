{if $exist == true}
  <table class="table table-bordered">
      <thead>
        <tr>
          <th style="border: 1px solid;">Informations Nutritionnelles</th>
        </tr>
      </thead>
      <tbody>
      {foreach from=$values item=$data}
        <tr>
          <td scope="row" style="border: 1px solid;">{$data["name"]}</td>
          <td class="active" style="border: 1px solid;">{$data["valeur"]}g</td>
        </tr>
      {/foreach}
      </tbody>
  </table>
{/if}
