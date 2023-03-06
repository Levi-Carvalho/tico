const interactions = document.querySelectorAll('.interaction');

interactions.forEach(interaction => {
  const btns = interaction.querySelectorAll('a');

  btns.forEach(btn => {
    btn.onclick = async e => {
      e.preventDefault();

      const res = await fetch(btn.href);
      const val = await res.text();

      if (val) {
        const data = JSON.parse(val);

        console.log(data);

        const likeNumber = btn.querySelector('span');
        const likeNum = likeNumber.textContent;

        if (data.already_did) {
          likeNumber.innerHTML = parseInt(likeNum) - 1;
          likeNumber.closest('.interaction').classList.toggle('active');
        } else {
          likeNumber.innerHTML = parseInt(likeNum) + 1;
          likeNumber.closest('.interaction').classList.toggle('active');
        }

        if (data.undid_oposite) {
          console.log('desfez oposto');

          const likes = btn.closest('div').querySelector('.likes');
          const dislikes = btn.closest('div').querySelector('.dislikes');

          if (data.action == 'like') {
            dislikes.innerHTML = parseInt(dislikes.innerHTML) - 1;
            dislikes.closest('.interaction').classList.toggle('active');
          } else if (data.action == 'dislike') {
            likes.innerHTML = parseInt(likes.innerHTML) - 1;
            likes.closest('.interaction').classList.toggle('active');
          }
        }
      } else {
        alert('Faça login para realizar essa ação.');
      }
    };
  });
});

document.querySelector('.ticos').addEventListener('click', e => {
    e.preventDefault();
    if(e.target.classList.contains("delete")){
        if(confirm("Tem certeza que deseja excluir?")){
            fetch(e.target.href)
            .then(res => res.text())
            .then(val => alert("deletado"));
            e.target.closest('.tico').remove();
        }
    }
})
