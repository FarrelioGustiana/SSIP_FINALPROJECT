<?php

function genId()
{
  $characters = "0123456789abcdefghijklmnopqrstuvwxyz01234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $charaIndexTotal = strlen($characters) - 1;

  $result = "u";

  for ($i = 0; $i < 14; $i++) {
    $ranInd = rand(0, $charaIndexTotal);
    $idChara = $characters[$ranInd];
    $result .= $idChara;
  }

  return $result;
}

function genIdExcpetuser()
{
  $characters = "0123456789abcdefghijklmnopqrstuvwxyz01234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $charaIndexTotal = strlen($characters) - 1;

  $result = "a";

  for ($i = 0; $i < 14; $i++) {
    $ranInd = rand(0, $charaIndexTotal);
    $idChara = $characters[$ranInd];
    $result .= $idChara;
  }

  return $result;
}

function genCategoryId()
{
  $characters = "0123456789abcdefghijklmnopqrstuvwxyz01234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $charaIndexTotal = strlen($characters) - 1;

  $result = "b";

  for ($i = 0; $i < 14; $i++) {
    $ranInd = rand(0, $charaIndexTotal);
    $idChara = $characters[$ranInd];
    $result .= $idChara;
  }

  return $result;
}

function genAppointmentId()
{
  $characters = "0123456789abcdefghijklmnopqrstuvwxyz01234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $charaIndexTotal = strlen($characters) - 1;

  $result = "p";

  for ($i = 0; $i < 14; $i++) {
    $ranInd = rand(0, $charaIndexTotal);
    $idChara = $characters[$ranInd];
    $result .= $idChara;
  }

  return $result;
}

function genBookedAppoinmentId()
{
  $characters = "0123456789abcdefghijklmnopqrstuvwxyz01234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $charaIndexTotal = strlen($characters) - 1;

  $result = "r";

  for ($i = 0; $i < 14; $i++) {
    $ranInd = rand(0, $charaIndexTotal);
    $idChara = $characters[$ranInd];
    $result .= $idChara;
  }

  return $result;
}

function generateCommentId()
{
  $characters = "0123456789abcdefghijklmnopqrstuvwxyz01234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $charaIndexTotal = strlen($characters) - 1;

  $result = "c";

  for ($i = 0; $i < 14; $i++) {
    $ranInd = rand(0, $charaIndexTotal);
    $idChara = $characters[$ranInd];
    $result .= $idChara;
  }

  return $result;
}
