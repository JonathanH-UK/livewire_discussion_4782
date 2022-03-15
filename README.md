Complex form dragged out from live project into this test repo.
It ain't pretty but it demostrated the problem.
Should present the form at '/' when served up. To reproduce the problem,
select a value from any module or trainer dropdown.

Expected behaviour is that the neighbouring select is highlighted as
invalid to enforce selection of a value.

To see it work as expected, downgrade Livewire to 2.8.0 and reload.
