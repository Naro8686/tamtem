<?php

namespace App\Services\FinanceOperation;

use App\Models\FinanceOperation;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use Auth;

class FinanceOperationService
{
  
    /**
     * Проверка, существует ли колонка со значением
    * @param Request $request
    * @return Collection
    */
    public function isRowValueExists($row, $val) {
        return FinanceOperation::where($row, $val)->exists();
    }

    /**
     * @param int $id
     * @return FinanceOperation
     * @throws Exception
     */
    public function getRowValue($row, $val)
    {
        /** @var FinanceOperation $financeOperation */
        $financeOperation = FinanceOperation::where($row, '=', $val)->first();
        return $financeOperation;
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function index(Request $request)
    {
        $query = FinanceOperation::query();

        $user =Auth::guard('api')->user();

        $query->where('user_id', '=', $user->id)->orderBy('created_at', 'desc');

        return $query->select([ 'id',  
                                'user_id',
                                'order_id',
                                'amount',
                                'payment_system',
                                'payment_to',
                                'status',
                                'text',
                                'request',
                                'result',
                                'decode_result',
                                'created_at', 
                                'updated_at'])->paginate(15);
    }

    /**
     * @param int $id
     * @return FinanceOperation
     * @throws Exception
     */
    public function get(int $id)
    {
      
        
        /** @var FinanceOperation $financeOperation */
        $financeOperation = FinanceOperation::where('id', '=', $id);

        $financeOperation->where('user_id', '=', $user->id);

        $financeOperation = $financeOperation->first();

        if (null === $financeOperation) {
            $financeOperation = "Операция {$id} не найдена или не доступна для вас";
        }

        return $financeOperation;
    }

    /**
     * @param array $data
     * @return FinanceOperation
     */
    public function create(array $data)
    {

        $financeOperation = new FinanceOperation();
        $financeOperation->create($data);    

        return $financeOperation;
    }

    /**
     * @param int $id
     * @param array $data
     * @return FinanceOperation
     * @throws Exception
     */
    public function update(int $id, array $data)
    {
        $financeOperation = $this->get($id);

        if($financeOperation instanceof FinanceOperation){

            if( $financeOperation->status === FinanceOperation::PAYMENT_STATUS_PAID){
                $financeOperation = "Статуc текущей операции уже: Оплачено";
            }

            $financeOperation->update($data);

            $financeOperation->save();
        }

        return $financeOperation;
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function delete(int $id)
    {
        $financeOperation = $this->get($id);

        if($financeOperation instanceof FinanceOperation){
            $financeOperation->delete();
        }
        return $financeOperation;
    }


    /**
     * storeLocalPayment запись в финансовые операции на беке
     *
     * @param  mixed $user
     * @param  mixed $order_id
     * @param  mixed $amount
     * @param  mixed $payment_system
     * @param  mixed $payment_to
     * @param  mixed $status
     * @param  mixed $text
     * @param  mixed $request
     * @param  mixed $result
     * @param  mixed $decode_result
     *
     * @return void
     */
    public function storeLocalPayment($userId, $order_id = '', $amount = 0, $payment_system = 0, $payment_to = '', $status = 0, $text = '', $request = '', $result = '', $decode_result = '')
    { 

        // создадим запись в финансовых операциях
        $data = [
            'user_id'           => $userId,
            'order_id'          => $order_id,
            'amount'            => $amount,
            'payment_system'    => $payment_system,
            'payment_to'        => $payment_to,
            'status'            => $status,
            'text'              => $text,
            'request'           => $request,
            'result'            => $result,
            'decode_result'     => $decode_result,
        ];
        // dd($data);
        $financeOperation = $this->create($data);

        if(!($financeOperation instanceof FinanceOperation)){
            return "Не возможно создать запить в FinanceOperation   func(" .  __FUNCTION__ . ")";
        }

        return true;
    }
       
}
