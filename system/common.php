<?php

function base_path() {
  $filePath = $_SERVER['PHP_SELF'];
  $documentRoot = realpath($_SERVER['DOCUMENT_ROOT']);
  
  $basePath = str_replace($documentRoot, '', $filePath);
  $basePath = explode('/', $basePath);
  array_pop($basePath);
  $basePath = implode('/', $basePath);
  
  return $basePath;
}

function base_url() {
  return $_SERVER['HTTP_HOST'];
}