<?php
// Parse the remote YAML file
$remotes = yaml_parse_file('/opt/remote.site.yml', 0);

// Loop through each environment
foreach ($remotes as $remote => $variables) {
  // Loop through each environment variable and
  // save them to a config file
  $content = "";
  foreach ($variables as $key => $value) {
    $content .= sprintf("%s=%s\n", $key, $value);
  }
  if (false === file_put_contents(sprintf("/opt/remote/%s.config", $remote), $content)) {
    die(sprintf("ERROR: Couldn't save env file for remote site: %s\n", $remote));
  }
}
