<?php

use App\Enums\ServiceCall\Status as ServiceCallStatus;
use App\Models\ServiceCall;
use App\Models\Technical;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create((new ServiceCall)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('app_status')->default(ServiceCallStatus::Open->value);
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('callID')->unique();
            $table->string('subject')->nullable();
            $table->string('customer')->nullable();
            $table->string('custmrName')->nullable();
            $table->integer('contctCode')->nullable();
            $table->string('manufSN')->nullable();
            $table->string('internalSN')->nullable();
            $table->string('contractID')->nullable();
            $table->date('cntrctDate')->nullable();
            $table->date('resolDate')->nullable();
            $table->integer('resolTime')->nullable();
            $table->string('free_1')->nullable();
            $table->string('free_2')->nullable();
            $table->string('origin')->nullable();
            $table->string('itemCode')->nullable();
            $table->string('itemName')->nullable();
            $table->integer('itemGroup')->nullable();
            $table->integer('status')->nullable();
            $table->string('priority')->nullable();
            $table->string('callType')->nullable();
            $table->string('problemTyp')->nullable();
            $table->integer('assignee')->nullable();
            $table->longText('descrption')->nullable();
            $table->string('objType')->nullable();
            $table->integer('logInstanc')->nullable();
            $table->integer('userSign')->nullable();
            $table->date('createDate')->nullable();
            $table->integer('createTime')->nullable();
            $table->date('closeDate')->nullable();
            $table->integer('closeTime')->nullable();
            $table->integer('userSign2')->nullable();
            $table->date('updateDate')->nullable();
            $table->integer('SCL1Count')->nullable();
            $table->integer('SCL2Count')->nullable();
            $table->string('isEntitled')->nullable();
            $table->string('insID')->nullable();
            $table->string('technician')->nullable();
            $table->longText('resolution')->nullable();
            $table->string('Scl1NxtLn')->nullable();
            $table->integer('Scl2NxtLn')->nullable();
            $table->string('Scl3NxtLn')->nullable();
            $table->integer('Sc3NxtLn')->nullable();
            $table->string('Scl4NxtLn')->nullable();
            $table->string('Scl5NxtLn')->nullable();
            $table->string('isQueue')->nullable();
            $table->string('Queue')->nullable();
            $table->date('resolOnDat')->nullable();
            $table->integer('resolOnTim')->nullable();
            $table->date('respByDate')->nullable();
            $table->integer('respByTime')->nullable();
            $table->date('respOnDate')->nullable();
            $table->integer('respOnTime')->nullable();
            $table->integer('respAssign')->nullable();
            $table->date('AssignDate')->nullable();
            $table->integer('AssignTime')->nullable();
            $table->integer('UpdateTime')->nullable();
            $table->integer('responder')->nullable();
            $table->string('Transfered')->nullable();
            $table->integer('Instance')->nullable();
            $table->integer('DocNum')->nullable();
            $table->integer('Series')->nullable();
            $table->string('Handwrtten')->nullable();
            $table->string('PIndicator')->nullable();
            $table->date('StartDate')->nullable();
            $table->integer('StartTime')->nullable();
            $table->date('EndDate')->nullable();
            $table->integer('EndTime')->nullable();
            $table->integer('Duration')->nullable();
            $table->string('DurType')->nullable();
            $table->string('Reminder')->nullable();
            $table->integer('RemQty')->nullable();
            $table->string('RemType')->nullable();
            $table->date('RemDate')->nullable();
            $table->string('RemSent')->nullable();
            $table->integer('RemTime')->nullable();
            $table->integer('Location')->nullable();
            $table->json('CLIENT_COORDINATE')->nullable()->comment('Buffer de la dirección del usuario');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('AddrName')->nullable();
            $table->string('AddrType')->nullable();
            $table->string('Street')->nullable();
            $table->string('City')->nullable();
            $table->string('Room')->nullable();
            $table->string('State')->nullable();
            $table->string('Country')->nullable();
            $table->string('DisplInCal')->nullable();
            $table->string('SupplCode')->nullable();
            $table->string('Attachment')->nullable();
            $table->string('AtcEntry')->nullable();
            $table->string('NumAtCard')->nullable();
            $table->string('ProSubType')->nullable();
            $table->string('BPType')->nullable();
            $table->string('Telephone')->nullable();
            $table->string('BPPhone1')->nullable();
            $table->string('BPPhone2')->nullable();
            $table->string('BPCellular')->nullable();
            $table->string('BPFax')->nullable();
            $table->string('BPShipCode')->nullable();
            $table->string('BPShipAddr')->nullable();
            $table->string('BPBillCode')->nullable();
            $table->string('BPBillAddr')->nullable();
            $table->string('BPTerrit')->nullable();
            $table->string('BPE_Mail')->nullable();
            $table->string('BPProjCode')->nullable();
            $table->string('BPContact')->nullable();
            $table->string('OwnerCode')->nullable();
            $table->string('DPPStatus')->nullable();
            $table->string('EncryptIV')->nullable();
            $table->string('Printed')->nullable();
            $table->integer('DataVers')->nullable();
            $table->text('U_DK_NUM_FACT')->nullable();
            $table->string('U_DK_F_COMP')->nullable();
            $table->text('U_DK_Modelo')->nullable();
            $table->text('U_DK_Marca')->nullable();
            $table->text('U_DK_TIPO_ACT')->nullable();
            $table->text('U_DK_ST_ACT')->nullable();
            $table->text('U_DK_FALLA')->nullable();
            $table->string('U_DK_F_ENVIO_CDD')->nullable();
            $table->string('U_DK_F_CULM_TEC')->nullable();
            $table->string('U_DK_F_ENV_TDA')->nullable();
            $table->string('U_DK_F_ENT_CLI')->nullable();
            $table->text('U_DK_TIENDA')->nullable();
            $table->text('U_DK_F_DIAGN')->nullable();
            $table->text('U_DK_F_NOT_CLI')->nullable();
            $table->text('U_DK_QUEJA')->nullable();
            $table->text('U_DK_DIAS_GEST')->nullable();
            $table->text('U_DK_CallType')->nullable();
            $table->text('U_DK_ORIGEN')->nullable();
            $table->text('U_RMA1')->nullable();
            $table->text('U_RMA2')->nullable();
            $table->text('U_DUPLICADO')->nullable();
            $table->text('U_TEC_Asignado')->nullable();
            $table->text('U_F_ENVIO_CDD')->nullable();
            $table->text('U_BM_NUMDOC')->nullable();
            $table->text('U_BM_SUCDEST')->nullable();
            $table->boolean('U_FORANEO')->default(true);
            $table->foreignIdFor(Technical::class, 'ASSIGNED_TECHNICIAN');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists((new ServiceCall)->getTable());
    }
};
