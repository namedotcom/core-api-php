<?php

namespace Namecom\Types;

enum RequirementFieldType: string
{
    case String = "string";
    case Notice = "notice";
    case Acknowledgement = "acknowledgement";
    case Enum = "enum";
    case Boolean = "boolean";
}
