<?php

class CLI {
    private Ledger $ledger;

    public function __construct(Ledger $ledger) {
        $this->ledger = $ledger;
    }

    public function run(): void {
        while (true) {
            echo "1. Add income\n";
            echo "2. Add expense\n";
            echo "3. View incomes\n";
            echo "4. View expenses\n";
            echo "5. View savings\n";
            echo "6. View categories\n";
            echo "7. Exit\n";
            echo "Enter your option: ";
            $option = trim(fgets(STDIN));

            switch ($option) {
                case '1':
                    $this->addIncome();
                    break;
                case '2':
                    $this->addExpense();
                    break;
                case '3':
                    $this->viewEntries('income');
                    break;
                case '4':
                    $this->viewEntries('expense');
                    break;
                case '5':
                    $this->viewSavings();
                    break;
                case '6':
                    $this->viewCategories();
                    break;
                case '7':
                    exit;
                default:
                    echo "Invalid option. Please try again.\n";
            }
        }
    }

    private function addIncome(): void {
        $this->addEntry('income');
    }

    private function addExpense(): void {
        $this->addEntry('expense');
    }

    private function addEntry(string $type): void {
        echo "Enter amount: ";
        $amount = (float)trim(fgets(STDIN));

        echo "Enter category: ";
        $categoryName = trim(fgets(STDIN));
        $category = new Category($categoryName);

        echo "Enter description: ";
        $description = trim(fgets(STDIN));

        $entry = new Entry($type, $amount, $category, $description);
        $this->ledger->addEntry($entry);

        echo ucfirst($type) . " added successfully.\n";
    }

    private function viewEntries(string $type): void {
        $entries = $this->ledger->getEntries($type);
        foreach ($entries as $entry) {
            echo "{$entry->getDescription()} - {$entry->getAmount()} ({$entry->getCategory()->getName()})\n";
        }
    }

    private function viewSavings(): void {
        $savings = $this->ledger->getSavings();
        echo "Total savings: $savings\n";
    }

    private function viewCategories(): void {
        $categories = $this->ledger->getCategories();
        foreach ($categories as $category) {
            echo "$category\n";
        }
    }
}
