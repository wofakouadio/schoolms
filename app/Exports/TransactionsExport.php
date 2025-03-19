<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'Invoice ID',
            'Student ID',
            'Student Name',
            'Level',
            'Term',
            'Academic Year', 
            'Description',
            'Amount Due',
            'Amount Paid',
            'Balance',
            'Transaction Type',
            'Status',
            'Paid At',
            'Created At',
            'Reference'
        ];
    }

    public function map($transaction): array
    {
        $status = '';
        if ($transaction->payment_status == 'awaiting_payment') {
            $status = 'Unpaid';
        } elseif ($transaction->payment_status == 'partial_payment') {
            $status = 'Partially Paid';
        } elseif ($transaction->payment_status == 'paid') {
            $status = 'Paid';
        }

        return [
            $transaction->invoice_id,
            $transaction->student->student_id,
            $transaction->student->student_firstname . ' ' . $transaction->student->student_othername . ' ' . $transaction->student->student_lastname,
            $transaction->level->level_name,
            $transaction->term->term_name,
            $transaction->academic_year->academic_year_start . '/' . $transaction->academic_year->academic_year_end,
            $transaction->description,
            $transaction->currency . ' ' . $transaction->amount_due,
            $transaction->currency . ' ' . $transaction->amount_paid,
            $transaction->currency . ' ' . $transaction->balance,
            $transaction->transaction_type,
            $status,
            $transaction->paid_at,
            $transaction->created_at,
            $transaction->reference
        ];
    }
}