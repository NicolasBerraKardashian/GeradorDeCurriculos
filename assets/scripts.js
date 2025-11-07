(function(){
  document.addEventListener('DOMContentLoaded', function(){
    const addExp = document.getElementById('addExp');
    const experiences = document.getElementById('experiences');
    const addEdu = document.getElementById('addEdu');
    const educations = document.getElementById('educations');
    const addRef = document.getElementById('addRef');
    const refs = document.getElementById('refs');
    const dob = document.getElementById('dob');
    const ageDisplay = document.getElementById('ageDisplay');
    const clearBtn = document.getElementById('clearBtn');

    function makeElem(html){
      const div = document.createElement('div');
      div.innerHTML = html;
      return div.firstElementChild;
    }

    addExp.addEventListener('click', function(){
      const template = `
      <div class="experience-item border p-3 rounded relative">
        <button type="button" class="remove-btn absolute top-2 right-2 text-sm">Remover</button>
        <input name="exp_title[]" placeholder="Cargo" class="border p-2 rounded w-full mb-2" />
        <input name="exp_company[]" placeholder="Empresa" class="border p-2 rounded w-full mb-2" />
        <input name="exp_period[]" placeholder="Período (ex: 2020 - 2022)" class="border p-2 rounded w-full mb-2" />
        <textarea name="exp_desc[]" placeholder="Descrição" class="border p-2 rounded w-full"></textarea>
      </div>`;
      const el = makeElem(template);
      experiences.appendChild(el);
    });

    addEdu.addEventListener('click', function(){
      const template = `
      <div class="education-item border p-3 rounded relative">
        <button type="button" class="remove-btn absolute top-2 right-2 text-sm">Remover</button>
        <input name="edu_course[]" placeholder="Curso" class="border p-2 rounded w-full mb-2" />
        <input name="edu_inst[]" placeholder="Instituição" class="border p-2 rounded w-full mb-2" />
        <input name="edu_period[]" placeholder="Período / Conclusão" class="border p-2 rounded w-full" />
      </div>`;
      const el = makeElem(template);
      educations.appendChild(el);
    });

    addRef.addEventListener('click', function(){
      const template = `
      <div class="ref-item border p-3 rounded relative">
        <button type="button" class="remove-btn absolute top-2 right-2 text-sm">Remover</button>
        <input name="ref_name[]" placeholder="Nome" class="border p-2 rounded w-full mb-2" />
        <input name="ref_contact[]" placeholder="Contato / Relação" class="border p-2 rounded w-full" />
      </div>`;
      const el = makeElem(template);
      refs.appendChild(el);
    });

    document.addEventListener('click', function(e){
      if (e.target && e.target.classList.contains('remove-btn')){
        const parent = e.target.closest('.experience-item, .education-item, .ref-item');
        if (parent) parent.remove();
      }
    });

    if (dob){
      dob.addEventListener('change', function(){
        const val = dob.value;
        if (!val) return ageDisplay.textContent = 'Idade: —';
        const birth = new Date(val);
        const today = new Date();
        let age = today.getFullYear() - birth.getFullYear();
        const m = today.getMonth() - birth.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
        ageDisplay.textContent = 'Idade: ' + age + ' anos';
      });
    }

    clearBtn.addEventListener('click', function(){
      if (!confirm('Deseja limpar todos os campos?')) return;
      document.getElementById('cvForm').reset();
      ageDisplay.textContent = 'Idade: —';
      // remove dynamically added items (keep first default ones)
      const extras = experiences.querySelectorAll('.experience-item');
      extras.forEach((el, idx) => { if (idx>0) el.remove(); });
      const eds = educations.querySelectorAll('.education-item');
      eds.forEach((el, idx) => { if (idx>0) el.remove(); });
      const rfs = refs.querySelectorAll('.ref-item');
      rfs.forEach((el, idx) => { if (idx>0) el.remove(); });
    });

    const previewBtn = document.getElementById('previewBtn');
    previewBtn.addEventListener('click', function(){
      alert('Para visualizar, clique em "Gerar Currículo" (abre em nova aba onde pode imprimir).');
    });

  });
})();
