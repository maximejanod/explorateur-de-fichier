
const   views   = document.querySelectorAll('.b-view')
      , length  = views.length;

for(let i = 0; i < length; i++) {

  const view = views[i];

  view.addEventListener('click', e => {

    e.preventDefault();

    window.location.href = `${view.dataset.uri}${view.dataset.view}`;

  });

}
