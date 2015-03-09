{if $flash->hasFlash('success')}<div id="flash-success" class="notice success"><p>{$flash->getFlash('success')}</p></div>{/if}
{if $flash->hasFlash('error')}<div id="flash-error" class="notice error"><p>{$flash->getFlash('error')}</p></div>{/if}
{if $flash->hasFlash('info')}<div id="flash-error" class="notice info"><p>{$flash->getFlash('info')}</p></div>{/if}