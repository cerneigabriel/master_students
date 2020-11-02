<?php

$app->router->get("/", "frontend.index");

$app->router->get("/about", "frontend.about");

$app->router->get("/contact", "frontend.contact");


$app->router->get("/admin", "backend.index");
