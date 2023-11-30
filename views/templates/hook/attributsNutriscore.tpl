<table class="table table-bordered">
<thead>
    <tr>
      <th>Informations Nutritionnelles</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$values item=$data}
    <tr>
      <td scope="row">{$data["name"]}</td>
      <td class="active">{$data["valeur"]}g</td>
    </tr>
  {/foreach}
  </tbody>
</table>