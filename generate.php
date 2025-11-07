<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function safe($v) {
    return htmlspecialchars(trim($v ?? ''));
}

$name = safe($_POST['name'] ?? '');
$email = safe($_POST['email'] ?? '');
$phone = safe($_POST['phone'] ?? '');
$dob = safe($_POST['dob'] ?? '');
$city = safe($_POST['city'] ?? '');
$state = safe($_POST['state'] ?? '');
$summary = safe($_POST['summary'] ?? '');

$exp_title = $_POST['exp_title'] ?? [];
$exp_company = $_POST['exp_company'] ?? [];
$exp_period = $_POST['exp_period'] ?? [];
$exp_desc = $_POST['exp_desc'] ?? [];

$edu_course = $_POST['edu_course'] ?? [];
$edu_inst = $_POST['edu_inst'] ?? [];
$edu_period = $_POST['edu_period'] ?? [];

$ref_name = $_POST['ref_name'] ?? [];
$ref_contact = $_POST['ref_contact'] ?? [];

function calc_age($dob) {
    if (!$dob) return '';
    try {
        $birth = new DateTime($dob);
        $today = new DateTime();
        return $today->diff($birth)->y;
    } catch (Exception $e) {
        return '';
    }
}
$age = calc_age($dob);
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Currículo - <?= $name ?: 'Sem nome' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    @media print { .no-print { display: none; } }
  </style>
</head>
<body class="bg-white text-gray-900 p-6">
  <div class="max-w-3xl mx-auto border p-6 rounded">
    <header class="mb-4">
      <h1 class="text-2xl font-bold"><?= $name ?: 'Nome do candidato' ?></h1>
      <div class="text-sm text-gray-600">
        <?= $city ? ($city . ($state ? ' - ' . $state : '')) : '' ?> <?= $age ? '• ' . $age . ' anos' : '' ?>
      </div>
      <div class="text-sm text-gray-600">
        <?= $email ?> <?= $phone ? '• ' . $phone : '' ?>
      </div>
    </header>

    <?php if ($summary): ?>
      <section class="mb-4">
        <h2 class="font-semibold">Resumo</h2>
        <p class="text-sm text-gray-800"><?= nl2br($summary) ?></p>
      </section>
    <?php endif; ?>

    <?php if (!empty($exp_title)): ?>
      <section class="mb-4">
        <h2 class="font-semibold">Experiência Profissional</h2>
        <?php for ($i = 0; $i < count($exp_title); $i++):
          $title = safe($exp_title[$i] ?? '');
          $company = safe($exp_company[$i] ?? '');
          $period = safe($exp_period[$i] ?? '');
          $desc = safe($exp_desc[$i] ?? '');
          if (!$title && !$company && !$desc) continue;
        ?>
          <div class="mb-2">
            <div>
              <div class="font-medium"><?= $title ?: $company ?></div>
             <?php if ($period): ?>
                <div class="text-sm text-gray-600"><?= $period ?></div>
             <?php endif; ?>
            </div>
            <?php if ($desc): ?><div class="text-sm text-gray-800"><?= nl2br($desc) ?></div><?php endif; ?>
          </div>
        <?php endfor; ?>
      </section>
    <?php endif; ?>

    <?php if (!empty($edu_course)): ?>
      <section class="mb-4">
        <h2 class="font-semibold">Formação</h2>
        <?php for ($i = 0; $i < count($edu_course); $i++):
          $course = safe($edu_course[$i] ?? '');
          $inst = safe($edu_inst[$i] ?? '');
          $period = safe($edu_period[$i] ?? '');
          if (!$course && !$inst) continue;
        ?>
          <div class="mb-2">
            <div class="font-medium"><?= $course ?></div>
            <div class="text-sm text-gray-600"><?= $inst ?> <?= $period ? '• ' . $period : '' ?></div>
          </div>
        <?php endfor; ?>
      </section>
    <?php endif; ?>

    <?php if (!empty($ref_name)): ?>
      <section class="mb-4">
        <h2 class="font-semibold">Referências</h2>
        <?php for ($i = 0; $i < count($ref_name); $i++):
          $rname = safe($ref_name[$i] ?? '');
          $rcontact = safe($ref_contact[$i] ?? '');
          if (!$rname && !$rcontact) continue;
        ?>
          <div class="mb-1 text-sm"><?= $rname ?> <?= $rcontact ? '• ' . $rcontact : '' ?></div>
        <?php endfor; ?>
      </section>
    <?php endif; ?>

    <div class="mt-6 no-print flex gap-2">
      <button onclick="window.print()" class="px-3 py-2 bg-blue-600 text-white rounded">Imprimir / Salvar PDF</button>
      <a href="index.php" class="px-3 py-2 bg-gray-300 rounded">Voltar</a>
    </div>
  </div>
</body>
</html>