<?php

namespace Namecom;

enum Environments: string
{
    case Sandbox = "https://api.dev.name.com";
    case Production = "https://api.name.com";
}
