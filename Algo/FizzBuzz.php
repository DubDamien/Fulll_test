<?php

declare(strict_types=1);

class FizzBuzz {
    private array $rules;

    public function __construct(array $rules = [3 => 'Fizz', 5 => 'Buzz']) {
        $this->rules = $rules;
    }

    public function getValue(int $number): string {
        $output = '';
        foreach ($this->rules as $divisor => $word) {
            if ($number % $divisor === 0) {
                $output .= $word;
            }
        }
        return $output ?: (string)$number;
    }

    public function printOutput(int $n): void {
        for ($i = 1; $i <= $n; $i++) {
            echo $this->getValue($i) . PHP_EOL;
        }
    }
}

$argc = $argc ?? 1;
$n = $argc > 1 ? (int)$argv[1] : 100;

$fizzBuzz = new FizzBuzz();
$fizzBuzz->printOutput($n);