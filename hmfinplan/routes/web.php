<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::post('/home/debug', [App\Http\Controllers\HomeController::class, 'debug'])->name('debug');

// customer controller
Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('customers');
Route::get('/customers/{customer}/dashboard', [App\Http\Controllers\CustomerController::class, 'show'])->name('customer.dashboard');
Route::delete('/customers/{customer}', [App\Http\Controllers\CustomerController::class, 'destroy']);
Route::patch('/customers/{customer}', [App\Http\Controllers\CustomerController::class, 'update']);
Route::post('/customers', [App\Http\Controllers\CustomerController::class, 'store']);

// personal details controller
Route::get('/customers/{customer}/personal', [App\Http\Controllers\PersonalDetailController::class, 'index'])->name('customer.personal');
Route::post('/customers/{customer}/personal', [App\Http\Controllers\PersonalDetailController::class, 'store']);
Route::patch('/customers/{customer}/personal/{personal}', [App\Http\Controllers\PersonalDetailController::class, 'update']);
Route::delete('/customers/{customer}/personal/{personal}', [App\Http\Controllers\PersonalDetailController::class, 'destroy']);

// family member controller
Route::get('/customers/{customer}/family', [App\Http\Controllers\FamilyMemberController::class, 'index'])->name('customer.family');
Route::post('/customers/{customer}/family', [App\Http\Controllers\FamilyMemberController::class, 'store']);
Route::patch('/customers/{customer}/family/{family}', [App\Http\Controllers\FamilyMemberController::class, 'update']);
Route::delete('/customers/{customer}/family/{family}', [App\Http\Controllers\FamilyMemberController::class, 'destroy']);

// profession detail controller
Route::get('/customers/{customer}/profession', [App\Http\Controllers\ProfessionalDetailsController::class, 'index'])->name('customer.profession');
Route::post('/customers/{customer}/profession', [App\Http\Controllers\ProfessionalDetailsController::class, 'store']);
Route::patch('/customers/{customer}/profession/{profession}', [App\Http\Controllers\ProfessionalDetailsController::class, 'update']);
Route::delete('/customers/{customer}/profession/{profession}', [App\Http\Controllers\ProfessionalDetailsController::class, 'destroy']);

// real estate controller
Route::get('/customers/{customer}/assets/realestate', [App\Http\Controllers\RealEstateController::class, 'index'])->name('customer.realestate');
Route::post('/customers/{customer}/assets/realestate', [App\Http\Controllers\RealEstateController::class, 'store']);
Route::patch('/customers/{customer}/assets/realestate/{realestate}', [App\Http\Controllers\RealEstateController::class, 'update']);
Route::delete('/customers/{customer}/assets/realestate/{realestate}', [App\Http\Controllers\RealEstateController::class, 'destroy']);

// personal items controller
Route::get('/customers/{customer}/assets/personalitem', [App\Http\Controllers\PersonalItemController::class, 'index'])->name('customer.personalitem');
Route::post('/customers/{customer}/assets/personalitem', [App\Http\Controllers\PersonalItemController::class, 'store']);
Route::patch('/customers/{customer}/assets/personalitem/{personalItem}', [App\Http\Controllers\PersonalItemController::class, 'update']);
Route::delete('/customers/{customer}/assets/personalitem/{personalItem}', [App\Http\Controllers\PersonalItemController::class, 'destroy']);

// bank asset controller
Route::get('/customers/{customer}/assets/bank', [App\Http\Controllers\BankAssetController::class, 'index'])->name('customer.bank');
Route::post('/customers/{customer}/assets/bank', [App\Http\Controllers\BankAssetController::class, 'store']);
Route::patch('/customers/{customer}/assets/bank/{bank}', [App\Http\Controllers\BankAssetController::class, 'update']);
Route::delete('/customers/{customer}/assets/bank/{bank}', [App\Http\Controllers\BankAssetController::class, 'destroy']);

// fixed asset controller
Route::get('/customers/{customer}/assets/fixedasset', [App\Http\Controllers\FixedAssetController::class, 'index'])->name('customer.fixedAsset');
Route::post('/customers/{customer}/assets/fixedasset', [App\Http\Controllers\FixedAssetController::class, 'store']);
Route::patch('/customers/{customer}/assets/fixedasset/{fixedAsset}', [App\Http\Controllers\FixedAssetController::class, 'update']);
Route::delete('/customers/{customer}/assets/fixedasset/{fixedAsset}', [App\Http\Controllers\FixedAssetController::class, 'destroy']);

// investment asset controller
Route::get('/customers/{customer}/assets/investmentasset', [App\Http\Controllers\InvestmentAssetController::class, 'index'])->name('customer.investmentAsset');
Route::post('/customers/{customer}/assets/investmentasset', [App\Http\Controllers\InvestmentAssetController::class, 'store']);
Route::patch('/customers/{customer}/assets/investmentasset/{investmentAsset}', [App\Http\Controllers\InvestmentAssetController::class, 'update']);
Route::delete('/customers/{customer}/assets/investmentasset/{investmentAsset}', [App\Http\Controllers\InvestmentAssetController::class, 'destroy']);

// epf controller
Route::get('/customers/{customer}/assets/retirementasset', [App\Http\Controllers\RetirementAssetController::class, 'index'])->name('customer.retirementAsset');
Route::post('/customers/{customer}/assets/retirementasset', [App\Http\Controllers\RetirementAssetController::class, 'store']);
Route::patch('/customers/{customer}/assets/retirementasset/{retirementAsset}', [App\Http\Controllers\RetirementAssetController::class, 'update']);
Route::delete('/customers/{customer}/assets/retirementasset/{retirementAsset}', [App\Http\Controllers\RetirementAssetController::class, 'destroy']);

// liabilities controller
Route::get('/customers/{customer}/liabilities', [App\Http\Controllers\LiabilityController::class, 'index'])->name('customer.liability');
Route::post('/customers/{customer}/liabilities', [App\Http\Controllers\LiabilityController::class, 'store']);
Route::patch('/customers/{customer}/liabilities/{liability}', [App\Http\Controllers\LiabilityController::class, 'update']);
Route::delete('/customers/{customer}/liabilities/{liability}', [App\Http\Controllers\LiabilityController::class, 'destroy']);

// Salary Income controller
Route::get('/customers/{customer}/salaryincomes', [App\Http\Controllers\SalaryIncomeController::class, 'index'])->name('customer.salary');
Route::post('/customers/{customer}/salaryincomes', [App\Http\Controllers\SalaryIncomeController::class, 'store']);
Route::patch('/customers/{customer}/salaryincomes/{salaryIncome}', [App\Http\Controllers\SalaryIncomeController::class, 'update']);
Route::delete('/customers/{customer}/salaryincomes/{salaryIncome}', [App\Http\Controllers\SalaryIncomeController::class, 'destroy']);

// Pension income controller
Route::get('/customers/{customer}/pensionincomes', [App\Http\Controllers\PensionIncomeController::class, 'index'])->name('customer.pension');
Route::post('/customers/{customer}/pensionincomes', [App\Http\Controllers\PensionIncomeController::class, 'store']);
Route::patch('/customers/{customer}/pensionincomes/{pensionIncome}', [App\Http\Controllers\PensionIncomeController::class, 'update']);
Route::delete('/customers/{customer}/pensionincomes/{pensionIncome}', [App\Http\Controllers\PensionIncomeController::class, 'destroy']);

// Rental income controller
Route::get('/customers/{customer}/rentalincomes', [App\Http\Controllers\RentalIncomeController::class, 'index'])->name('customer.rental');
Route::post('/customers/{customer}/rentalincomes', [App\Http\Controllers\RentalIncomeController::class, 'store']);
Route::patch('/customers/{customer}/rentalincomes/{rentalIncome}', [App\Http\Controllers\RentalIncomeController::class, 'update']);
Route::delete('/customers/{customer}/rentalincomes/{rentalIncome}', [App\Http\Controllers\RentalIncomeController::class, 'destroy']);

// Other income controller
Route::get('/customers/{customer}/otherincomes', [App\Http\Controllers\OtherIncomeController::class, 'index'])->name('customer.other');
Route::post('/customers/{customer}/otherincomes', [App\Http\Controllers\OtherIncomeController::class, 'store']);
Route::patch('/customers/{customer}/otherincomes/{otherIncome}', [App\Http\Controllers\OtherIncomeController::class, 'update']);
Route::delete('/customers/{customer}/otherincomes/{otherIncome}', [App\Http\Controllers\OtherIncomeController::class, 'destroy']);

// expense controller
Route::get('/customers/{customer}/expenses', [App\Http\Controllers\ExpenseController::class, 'index'])->name('customer.expense');
Route::post('/customers/{customer}/expenses', [App\Http\Controllers\ExpenseController::class, 'store']);
Route::patch('/customers/{customer}/expenses/{expense}', [App\Http\Controllers\ExpenseController::class, 'update']);
Route::delete('/customers/{customer}/expenses/{expense}', [App\Http\Controllers\ExpenseController::class, 'destroy']);

// insurance controller
Route::get('/customers/{customer}/insurances', [App\Http\Controllers\InsuranceController::class, 'index'])->name('customer.insurance');
Route::post('/customers/{customer}/insurances', [App\Http\Controllers\InsuranceController::class, 'store']);
Route::patch('/customers/{customer}/insurances/{insurance}', [App\Http\Controllers\InsuranceController::class, 'update']);
Route::delete('/customers/{customer}/insurances/{insurance}', [App\Http\Controllers\InsuranceController::class, 'destroy']);

// goal controller
Route::get('/customers/{customer}/goals', [App\Http\Controllers\GoalController::class, 'index'])->name('customer.goal');
Route::post('/customers/{customer}/goals', [App\Http\Controllers\GoalController::class, 'store']);
Route::patch('/customers/{customer}/goals/{goal}', [App\Http\Controllers\GoalController::class, 'update']);
Route::delete('/customers/{customer}/goals/{goal}', [App\Http\Controllers\GoalController::class, 'destroy']);

// risk controller
Route::get('/customers/{customer}/risks', [App\Http\Controllers\RiskToleranceController::class, 'index'])->name('customer.risk');
Route::post('/customers/{customer}/risks', [App\Http\Controllers\RiskToleranceController::class, 'store']);
Route::patch('/customers/{customer}/risks', [App\Http\Controllers\RiskToleranceController::class, 'update']);
Route::delete('/customers/{customer}/risks', [App\Http\Controllers\RiskToleranceController::class, 'destroy']);

// Financial Plan Controller
Route::get('/customers/{customer}/financialplan', [App\Http\Controllers\FinancialPlanController::class, 'index'])->name('customer.finplan');
Route::get('/customers/{customer}/financialplan/iereport', [App\Http\Controllers\FinancialPlanController::class, 'IncomeAndExpense'])->name('customer.iereport');
Route::get('/customers/{customer}/financialplan/goalsreport', [App\Http\Controllers\FinancialPlanController::class, 'Goals'])->name('customer.goalsreport');
Route::get('/customers/{customer}/financialplan/balancesheet', [App\Http\Controllers\FinancialPlanController::class, 'BalanceSheet'])->name('customer.balancesheet');
Route::get('/customers/{customer}/financialplan/riskmgmt', [App\Http\Controllers\FinancialPlanController::class, 'RiskManagement'])->name('customer.riskmgmt');
Route::get('/customers/{customer}/financialplan/livingexpenses', [App\Http\Controllers\FinancialPlanController::class, 'LivingExpenses'])->name('customer.livingexpenses');
Route::get('/customers/{customer}/financialplan/epfreport', [App\Http\Controllers\FinancialPlanController::class, 'EpfReport'])->name('customer.epfreport');
Route::get('/customers/{customer}/financialplan/cashflow', [App\Http\Controllers\FinancialPlanController::class, 'CashFlowReport'])->name('customer.cashflow');
Route::get('/customers/{customer}/financialplan/xlsreport', [App\Http\Controllers\FinancialPlanController::class, 'GenerateReport'])->name('customer.xlsreport');
