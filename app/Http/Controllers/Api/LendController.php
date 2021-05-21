<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lend;
use Illuminate\Http\Request;

class LendController extends Controller
{
    private $lend;

    public function __construct(Lend $lend)
    {
        $this->lend = $lend;
    }

    public function lend_period_teste($data, $return, $id = null, $method = 'create')
    {
        if($data['start'] >= $data['end'])
        {
            return 'A data de inicio não pode ser igual ou maior que a do fim';
        }
        if((strtotime($data['end']) - strtotime($data['start']))/86400 > 5)
        {
            return 'A reserva deve durar no máximo 5 dias.';
        }

        $user_leeds = $this->lend->all()->where('user_id', $data['user_id'])->where('id', '!=', $id);
        $lends_in_same_period = 0;
        foreach($user_leeds as $lend)
        {
            if( $lend->book->user_id == $data['user_id'])
            {
                return 
                [
                    'problem' => 'Este livro pertence a você',
                    'lend' => $lend,
                ];
            }
            else if
            (
                $lend->user_id == $data['user_id'] 
                && $lend->book_id == $data['book_id']
                && $method == 'create'
            )
            {
                return 
                [
                    'problem' => 'Você já reservou este livro',
                    'lend' => $lend,
                ];
            }
            else if
            (
                (
                    $data['start'] > $lend->start && $data['end'] > $lend->end
                    && $data['end'] > $lend->start && $data['start'] > $lend->end
                )
                || 
                (
                    $data['start'] < $lend->start && $data['end'] < $lend->end
                    && $data['end'] < $lend->start && $data['start'] < $lend->end
                )
            )
            {}
            else
            {
                $lends_in_same_period += 1;
                if($lends_in_same_period >= 2)
                {
                    return 
                    [
                        'problem' => 'Você já reservou um livro entre o período escolhido',
                        'lend' => $lend,
                    ];
                }    
            }
        }

        $book_lends = $this->lend->all()->where('book_id', $data['book_id'])->where('id', '!=', $id);
        foreach($book_lends as $lend)
        {
            if
            (
                (
                    $data['start'] > $lend->start && $data['end'] > $lend->end
                    && $data['end'] > $lend->start && $data['start'] > $lend->end
                )
                || 
                (
                    $data['start'] < $lend->start && $data['end'] < $lend->end
                    && $data['end'] < $lend->start && $data['start'] < $lend->end
                )
            )
            {
                
            }
            else
            {
                return 
                [
                    'problem' => 'Já existe uma reserva entre o período escolhido',
                    'lend' => $lend,
                ];
            }
        }

        if($method == 'update')
        {
            $lend = $this->lend->find($id);
            $lend->update($data);
        }
        else
        {
            $this->lend->create($data);
        } 
        return $return;
    }

    public function index()
    {
        try
        {
            $lends = $this->lend->all();
            return response()->json(['data' => $lends], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['data' => ['msg' => $e->getMessage()]]);
        }  
    }

    public function store(Request $request)
    {
        $data = $request->all();
        try
        {
            $return = $this->lend_period_teste($data, 'Livro reservado com sucesso!');
            return response()->json(['data' => ['msg' => $return]], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['data' => ['msg' => $e->getMessage()]]);
        }
    }

    public function update($id, Request $request)
    {
        $data = $request->all();
        try
        {
            $lend = $this->lend->find($id);
            if(!$lend)
            {
                return response()->json(['data' => ['msg' => 'Rserva não encontrada']]);
            }
            $data['book_id'] = $lend->book_id;
            $return = $this->lend_period_teste($data, 'Reserva atualizada com sucesso!', $id, 'update');
            return response()->json(['data' => ['msg' => $return]], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['data' => ['msg' => $e->getMessage()]]);
        }
    }

    public function destroy($id)
    {
        try
        {
            $lend = $this->lend->find($id);
            if(!$lend)
            {
                return response()->json(['data' => ['msg' => 'Rserva não encontrada']]);
            }
            $lend->delete();
            return response()->json(['data' => ['msg' => 'Reserva desfeita com sucesso!']], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['data' => ['msg' => $e->getMessage()]]);
        }
    }

    public function show($id)
    {
        try
        {
            $lend = $this->lend->find($id);
            if(!$lend)
            {
                return response()->json(['data' => ['msg' => 'Rserva não encontrada']]);
            }
            $lend->user;
            $lend->book;
            return response()->json(['data' => $lend], 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['data' => ['msg' => $e->getMessage()]]);
        }
    }
}
