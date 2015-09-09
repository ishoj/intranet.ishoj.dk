<?php

$name = 'os2intra_organizaiton_tax';

echo "About to delete all terms in {$name}, CTRL-c to cancel this (you got 5 sec)\n";

sleep(5);

$vocabulary = taxonomy_vocabulary_machine_name_load($name);

$terms = entity_load('taxonomy_term', FALSE, array('vid' => $vocabulary->vid));

foreach ($terms as $term) {
  echo "Deleting {$term->name}\n";
  taxonomy_term_delete($term->tid);
}

echo "About to delete all users with only 'authenticated user', CTRL-c to cancel this (you got 5 sec)\n";

sleep(5);

$users = entity_load('user');
foreach ($users as $user) {
  if (count($user->roles) > 1) {
    continue;
  }

  if (array_shift($user->roles) !== 'authenticated user') {
    continue;
  }

  echo "Deleting {$user->name}\n";
  user_delete($user->uid);
}
