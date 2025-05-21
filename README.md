It's time to learn Laravel!

## Invoice system with cronjob

Goals:
- Check daily if there is an invoice that needs to be paid in 2 weeks
    - IF yes: send an email to the customer with a notification
    - If yes: send a notification through a discord webhook that an email has been sent to *email* regarding an invoice of *€price*

- Check daily if there is an invoice that needs to be paid in 3 days
    - If yes: send a notification through a discord webhook regarding the upcoming payment so it can be verified whether or not it has been paid
 
  Idea: Functionality to mark upcoming invoices as paid, so that there is no reminder to pay in 3 days. Maybe include a direct link through the webhook, so you only have to press the link to mark it as paid
