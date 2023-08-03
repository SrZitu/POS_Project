@extends('layout.sidenav-layout')
@section('site_title', 'Promotional Mail')
@section('content')

<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Promotional Mail</h4>
            <h6>Sending mail to all Happy Customers</h6>
        </div>
    </div>

    <div class="md:grid md:grid-cols-2 ">
        <div>
            <div class="card">
                <div class="card-body">
                    <form id="promotion_form">
                        <div class="form-group">
                            <label>subject</label>
                            <input type="text" class="form-control" id="subject">
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea id="message" cols="10" rows="10" class="form-control"></textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn custom-btn">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const promotion_form = document.getElementById('promotion_form');
    promotion_form.addEventListener('submit', async (e) => {
        e.preventDefault();
        try {
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;

            if (0 == subject.length) {
                errorToast('Subject  is Required');
            } else if (0 == message.length) {
                errorToast('Message is Required');
            } else {
                showLoader();
                const URL = "{{ route('promotion.mail') }}";
                const res = await axios.post(URL, {
                    subject: subject,
                    message: message
                });
                hideLoader();

                if (200 == res.status) {
                    promotion_form.reset();
                    successToast('Mail Sent Successfully');
                } else if (400 == res.status && 'failed' == res.data.status) {
                    promotion_form.reset();
                    successToast('Error Sending Mail');
                }
            }

        } catch (error) {
            console.log('Something went Wrong');
        }

    })
</script>

@endsection



