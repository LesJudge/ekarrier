<?php
namespace Uniweb\Library\DynamicFilter;

class ConditionsEnum
{
    const MATCH_STARTS_WITH = 'startsWith';
    const MATCH_ENDS_WITH = 'endsWith';
    const MATCH_ANYWHERE = 'anywhere';
    const MATCH_LESS_THAN = 'lessThan';
    const MATCH_LESS_THAN_OR_EQUALS = 'lessThanOrEqual';
    const MATCH_EQUALS = 'equals';
    const MATCH_GREATER_THAN = 'greaterThan';
    const MATCH_GREATER_THAN_OR_EQUALS = 'greaterThanOrEquals';
    const MATCH_BETWEEN = 'between';
}