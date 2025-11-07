<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gerador de Currículos - Minimalista</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
  <header class="bg-white shadow">
    <div class="max-w-4xl mx-auto p-4 flex items-center justify-between">
      <h1 class="text-xl font-semibold">Gerador de Currículos</h1>
      <nav class="text-sm text-gray-600">Por Nicolas Berra</nav>
    </div>
  </header>

  <main class="max-w-4xl mx-auto p-6">
    <form id="cvForm" action="generate.php" method="post" class="space-y-6 bg-white p-6 rounded shadow">

      <section>
        <h2 class="text-lg font-medium mb-2">Dados Pessoais</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <input name="name" placeholder="Nome completo" class="border p-2 rounded w-full" required />
          <input name="email" type="email" placeholder="E-mail" class="border p-2 rounded w-full" />
          <input name="phone" placeholder="Telefone" class="border p-2 rounded w-full" />
          <div>
            <input id="dob" name="dob" type="date" class="border p-2 rounded w-full" />
            <div id="ageDisplay" class="text-sm text-gray-600 mt-1">Idade: —</div>
          </div>
          <input name="city" placeholder="Cidade" class="border p-2 rounded w-full" />
          <input name="state" placeholder="Estado" class="border p-2 rounded w-full" />
        </div>
      </section>

      <section>
        <h2 class="text-lg font-medium mb-2">Resumo (opcional)</h2>
        <textarea name="summary" rows="4" placeholder="Resumo profissional / objetivo" class="border p-2 rounded w-full"></textarea>
      </section>

      <section id="experienceSection">
        <h2 class="text-lg font-medium mb-2">Experiências Profissionais</h2>
        <div id="experiences" class="space-y-4">
          <div class="experience-item border p-3 rounded">
            <input name="exp_title[]" placeholder="Cargo" class="border p-2 rounded w-full mb-2" />
            <input name="exp_company[]" placeholder="Empresa" class="border p-2 rounded w-full mb-2" />
            <input name="exp_period[]" placeholder="Período (ex: 2020 - 2022)" class="border p-2 rounded w-full mb-2" />
            <textarea name="exp_desc[]" placeholder="Descrição (responsabilidades, conquistas)" class="border p-2 rounded w-full"></textarea>
          </div>
        </div>
        <div class="mt-2">
          <button id="addExp" type="button" class="px-3 py-1 bg-gray-200 rounded">+ Adicionar experiência</button>
        </div>
      </section>

      <section id="educationSection">
        <h2 class="text-lg font-medium mb-2">Formação</h2>
        <div id="educations" class="space-y-4">
          <div class="education-item border p-3 rounded">
            <input name="edu_course[]" placeholder="Curso (ex: Ciência de Dados)" class="border p-2 rounded w-full mb-2" />
            <input name="edu_inst[]" placeholder="Instituição" class="border p-2 rounded w-full mb-2" />
            <input name="edu_period[]" placeholder="Período / Conclusão" class="border p-2 rounded w-full" />
          </div>
        </div>
        <div class="mt-2">
          <button id="addEdu" type="button" class="px-3 py-1 bg-gray-200 rounded">+ Adicionar formação</button>
        </div>
      </section>

      <section id="refsSection">
        <h2 class="text-lg font-medium mb-2">Referências Pessoais</h2>
        <div id="refs" class="space-y-4">
          <div class="ref-item border p-3 rounded">
            <input name="ref_name[]" placeholder="Nome" class="border p-2 rounded w-full mb-2" />
            <input name="ref_contact[]" placeholder="Contato / Relação" class="border p-2 rounded w-full" />
          </div>
        </div>
        <div class="mt-2">
          <button id="addRef" type="button" class="px-3 py-1 bg-gray-200 rounded">+ Adicionar referência</button>
        </div>
      </section>

      <div class="flex items-center space-x-3">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Gerar Currículo</button>
        <button id="clearBtn" type="button" class="px-3 py-2 bg-red-100 rounded">Limpar</button>
      </div>
    </form>

    <p class="text-sm text-gray-500 mt-4">
      Dica: após gerar, use “Imprimir” → “Salvar como PDF” para baixar seu currículo.
    </p>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const addExp = document.getElementById('addExp');
      const experiences = document.getElementById('experiences');
      const addEdu = document.getElementById('addEdu');
      const educations = document.getElementById('educations');
      const addRef = document.getElementById('addRef');
      const refs = document.getElementById('refs');
      const dob = document.getElementById('dob');
      const ageDisplay = document.getElementById('ageDisplay');
      const clearBtn = document.getElementById('clearBtn');

      function createBlock(html) {
        const div = document.createElement('div');
        div.innerHTML = html.trim();
        return div.firstElementChild;
      }

      addExp.addEventListener('click', function() {
        const block = createBlock(`
          <div class="experience-item border p-3 rounded relative">
            <button type="button" class="remove-btn absolute top-2 right-2 text-sm">Remover</button>
            <input name="exp_title[]" placeholder="Cargo" class="border p-2 rounded w-full mb-2" />
            <input name="exp_company[]" placeholder="Empresa" class="border p-2 rounded w-full mb-2" />
            <input name="exp_period[]" placeholder="Período (ex: 2020 - 2022)" class="border p-2 rounded w-full mb-2" />
            <textarea name="exp_desc[]" placeholder="Descrição" class="border p-2 rounded w-full"></textarea>
          </div>
        `);
        experiences.appendChild(block);
      });

      addEdu.addEventListener('click', function() {
        const block = createBlock(`
          <div class="education-item border p-3 rounded relative">
            <button type="button" class="remove-btn absolute top-2 right-2 text-sm">Remover</button>
            <input name="edu_course[]" placeholder="Curso" class="border p-2 rounded w-full mb-2" />
            <input name="edu_inst[]" placeholder="Instituição" class="border p-2 rounded w-full mb-2" />
            <input name="edu_period[]" placeholder="Período / Conclusão" class="border p-2 rounded w-full" />
          </div>
        `);
        educations.appendChild(block);
      });

      addRef.addEventListener('click', function() {
        const block = createBlock(`
          <div class="ref-item border p-3 rounded relative">
            <button type="button" class="remove-btn absolute top-2 right-2 text-sm">Remover</button>
            <input name="ref_name[]" placeholder="Nome" class="border p-2 rounded w-full mb-2" />
            <input name="ref_contact[]" placeholder="Contato / Relação" class="border p-2 rounded w-full" />
          </div>
        `);
        refs.appendChild(block);
      });

      document.addEventListener('click', e => {
        if (e.target.classList.contains('remove-btn')) {
          e.target.closest('.experience-item, .education-item, .ref-item').remove();
        }
      });

      dob.addEventListener('change', () => {
        const val = dob.value;
        if (!val) return ageDisplay.textContent = 'Idade: —';
        const birth = new Date(val);
        const today = new Date();
        let age = today.getFullYear() - birth.getFullYear();
        const m = today.getMonth() - birth.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
        ageDisplay.textContent = `Idade: ${age} anos`;
      });

      clearBtn.addEventListener('click', () => {
        if (confirm('Deseja limpar todos os campos?')) {
          document.getElementById('cvForm').reset();
          ageDisplay.textContent = 'Idade: —';
          experiences.innerHTML = '';
          educations.innerHTML = '';
          refs.innerHTML = '';
        }
      });
    });
  </script>
</body>
</html>