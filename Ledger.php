<?php

class Ledger {
    private array $entries = [];
    private string $dataFile;

    public function __construct(string $dataFile) {
        $this->dataFile = $dataFile;
        $this->loadData();
    }

    public function addEntry(Entry $entry): void {
        $this->entries[] = $entry;
        $this->saveData();
    }

    public function getEntries(string $type = null): array {
        if ($type === null) {
            return $this->entries;
        }
        return array_filter($this->entries, fn($entry) => $entry->getType() === $type);
    }

    public function getCategories(): array {
        $categories = array_map(fn($entry) => $entry->getCategory()->getName(), $this->entries);
        // var_dump($data);
        return array_unique($categories);
    }

    public function getSavings(): float {
        $totalIncome = array_sum(array_map(fn($entry) => $entry->getType() === 'income' ? $entry->getAmount() : 0, $this->entries));
        $totalExpense = array_sum(array_map(fn($entry) => $entry->getType() === 'expense' ? $entry->getAmount() : 0, $this->entries));
        return $totalIncome - $totalExpense;
    }

    private function loadData(): void {
        if (file_exists($this->dataFile)) {
            $data = json_decode(file_get_contents($this->dataFile), true);
            // var_dump($data);
            $this->entries = array_map(fn($entryData) => Entry::fromArray($entryData), $data);
        }
    }

    private function saveData(): void {
        $data = array_map(fn($entry) => $entry->toArray(), $this->entries);
        // var_dump($data);
        file_put_contents($this->dataFile, json_encode($data, JSON_PRETTY_PRINT));
    }
}
