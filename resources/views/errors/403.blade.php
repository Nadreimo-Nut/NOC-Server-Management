@extends('errors.layout')

@section('title', '403 - ปฏิเสธการเข้าถึง')
@section('code', '403')
@section('code_color', 'text-rose-400')
@section('message', 'คุณไม่มีสิทธิ์เข้าถึงส่วนงานนี้')
@section('description', 'หน้านี้สงวนไว้สำหรับเจ้าหน้าที่ศูนย์ปฏิบัติการเครือข่ายคอมพิวเตอร์ (NOC Superuser) หรือบทบาทที่ได้รับอนุญาตเท่านั้น')
