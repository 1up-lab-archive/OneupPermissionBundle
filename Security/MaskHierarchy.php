<?php

namespace Oneup\PermissionBundle\Security;

class MaskHierarchy
{
    protected $hierarchy;
    protected $masks;
    protected $map;

    public function __construct($hierarchy)
    {
        $this->hierarchy = $hierarchy;
        $this->masks = array_keys($hierarchy);

        $this->buildMap();
    }

    public function getMasks()
    {
        return $this->masks;
    }

    public function getReachable($masks)
    {
        if (!is_array($masks)) {
            $masks = (array) $masks;
        }

        $reachableMasks = $masks;
        foreach ($masks as $mask) {
            if (!isset($this->map[$mask])) {
                continue;
            }

            foreach ($this->map[$mask] as $m) {
                $reachableMasks[] = $m;
            }
        }

        return $reachableMasks;
    }

    private function buildMap()
    {
        $this->map = array();

        foreach ($this->hierarchy as $main => $masks) {
            $this->map[$main] = $masks;
            $visited = array();
            $additionalMasks = $masks;

            while ($mask = array_shift($additionalMasks)) {
                if (!isset($this->hierarchy[$mask])) {
                    continue;
                }

                $visited[] = $mask;
                $this->map[$main] = array_unique(array_merge($this->map[$main], $this->hierarchy[$mask]));
                $additionalMasks = array_merge($additionalMasks, array_diff($this->hierarchy[$mask], $visited));
            }
        }
    }
}
