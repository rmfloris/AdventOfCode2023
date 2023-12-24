<?php

namespace day19;

use common\Day;

class Day19 extends Day {

    /**
     * @var array<string, array<array{rating: ?string, compare: ?string, value: ?int, nextWorkflow: string}>>
     */
    private array $workflows;
    /**
     * @var array<array{x: int, m: int, a: int, s: int}>
     */
    private array $parts;

    protected function loadData(): void
    {
        parent::loadData();
        $workflows = [];
        foreach($this->inputData as $row) {
            if (preg_match("#(\w+){.*}#",$row, $matches)) {
                $workflows[] = $matches[0];
            } elseif (preg_match("#{x=(\d+),m=(\d+),a=(\d+),s=(\d+)}#",$row, $matches)) {
                $this->parts[] = [
                    "x" => $matches[1],
                    "m" => $matches[2],
                    "a" => $matches[3],
                    "s" => $matches[4]
                ];
            }
        }
        $this->processWorkflows($workflows);
    }

    private function processWorkflows(array $workflows): void {
        foreach($workflows as $workflow) {
            $workflowName = substr($workflow, 0, strpos($workflow, "{"));
            $rules = explode(",", substr($workflow, strpos($workflow, "{")+1, -1));

            foreach($rules as $rule) {
                if(preg_match("#(?P<rating>[^<>]+)(?P<compare>[<>])(?P<value>[^:]+):(?P<nextWorkflow>[^>]+)#", $rule, $matches)) {
                    $this->workflows[$workflowName][] = [
                        "rating"       => $matches["rating"],
                        "compare"      => $matches["compare"],
                        "value"        => $matches["value"],
                        "nextWorkflow" => $matches["nextWorkflow"]
                    ];
                } else {
                    $this->workflows[$workflowName][] = [
                        "rating"       => NULL,
                        "compare"      => NULL,
                        "value"        => NULL,
                        "nextWorkflow" => $rule 
                    ];
                }
            }
        }
    }

    // private function processParts(array $parts) {
    //     foreach($parts as $part) {
    //         echo $part ."<br>";
    //         preg_match("#x=(\d+),m=(\d+),a=(\d+),s=(\d+)#", $part, $matches);
    //         $this->parts[] = [
    //             "x" => $matches[1],
    //             "m" => $matches[2],
    //             "a" => $matches[3],
    //             "s" => $matches[4]
    //         ];
    //     }
    // }

    private function startWorkflow(): int {
        $totalValue = 0;

        foreach($this->parts as $part) {
            $workflow = "in";
            // echo "<hr>";
            // print_r($part);
            while (!in_array($workflow, ['A', 'R'])) {
                // echo "workflow: ". $workflow ."<br>";
                foreach ($this->workflows[$workflow] as $rule) {

                    if ('<' == $rule['compare'] && $part[$rule['rating']] < $rule['value']
                        || '>' == $rule['compare'] && $part[$rule['rating']] > $rule['value']
                        || null === $rule['compare']) {
                        $workflow = $rule['nextWorkflow'];

                        break;
                    }
                }
            }

            if($workflow === "A") {
                $totalValue += array_sum($part);
            }
        }
        return $totalValue;
    }

    public function part1(): int {
        return $this->startWorkflow();
    }

    public function part2(): int {
        return 1;
    }
    
}
