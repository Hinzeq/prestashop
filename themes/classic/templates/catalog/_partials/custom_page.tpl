{extends file='page.tpl'}

{block name='page_content'}
  <h1>Stworzony nowy widok za pomocą front controllera</h1>
  <p>Po naciśnięciu przycisku zostanie wczytane 10 losowych produktów.</p>
  <button id="my-function-button">Wczytaj</button>
  <div id="load-ten-product"></div><br/>
  <p>
  {if isset($smarty.get.test)}
    Jest: {$smarty.get.test}
  {else}
    Nie ma
  {/if}
  </p>
  <h2>{$valw}</h2>
{/block}