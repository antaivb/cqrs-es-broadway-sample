# CQRS - ES - Broadway sample
Cqrs Es with Broadway

# Applying Broadway
  - ###  Event Domain
    - Create Event Domain class (```UserWasCreated```)
    - Class implements ```Broadway\Serializer\Serializable```
    - Add 2 methods to deal this event: 
      - ```Serialize``` => return array
      - ```Deserialize``` => return Event Domain object
  - ### Model:
    - Create User Class with attributes and methods
      - Extends from ```Broadway\EventSourcing\EventSourcedAggregateRoot``` 
    - Add ```getAggregateRootId``` method with Aggregate Root Id
    - Add ```create``` factory function with functionality:
      - Create ```User``` instance
      - Call ```apply``` function with Event Domain instance filled
    - Add ```applyNameEventDomain``` protected function
      - Get information from Event Domain
      - Fill User object with data
  - ### Migration:
    - Add a new migration to create Event table (```Version20220317233829```)
  - ### Command Handler:
    - Call to ```create``` User model function
    - Call to ```userStore``` repository to store the event
  - ### Repository:
    - Create ```UserStoreRepository``` to store User events
    - Repository extends ```Broadway\EventSourcing\EventSourcingRepository```
    - Create 2 functions:
      - ```Store``` => store User event 
      - ```Get``` => get User event
  - ### Read Model and Projection:
    - #### Read Model
      - Create ```UserView``` Model (copy methods and attributes from User model)
        - Extends ```Broadway\ReadModel\SerializableReadModel```
        - Create constructor
        - Add ```serialize``` and ```deserialize``` function (in this case, similar to User model)
        - Add ```getId``` to return UserId (method required by ```SerializableReadModel```)
    - #### Projection
      - Create ```UserProjection``` class
        - Listening Event Domains configured into this class  
        - Extends from ```Broadway\ReadModel\Projector```
        - It has, for each event, one function with the name ```applyNameEventDomain``` (```UserWasCreated```)
          - Receive ```UserWasCreated``` parameter/event
          - Call ```UserRepository``` to save ```UserView``` with Doctrine into database 
    - #### Repository
      - Create a standard ```UserRepository``` with ```save``` function to store ```UserView``` model
  - ### Process manager:
    - #### Sync:
      - Create ```DomainEventHandler``` to catch all events executed in Broadway event bus.
        - Implements ```Broadway\EventHandling\EventListener``` to catch events
      - Create ```SendWelcomeEmailProcessManager``` with Domain Event as parameter (```UserWasCreated```) to send an email
    - #### Async:
      - Add in ```DomainEventHandler``` implementation of ```MessageSubscriberInterface``` to catch all events published in named queued "events".
        - Implements ```Symfony\Component\Messenger\Handler\MessageSubscriberInterface``` to catch events
        - Add ```getHandledMessages``` method to get events from queue "events"
        - Add ```__invoke``` method to send this event to Symfony event bus
      - Create ```DomainEventPublisher``` to dispatch Asynchronous messages to RabbitMQ
          - Implements ```EventListener``` to catch Broadway events and save in array message variable (in memory) 
          - Implements ```EventSubscriberInterface``` necessary to catch kernel events.
            - Create ```getSubscribedEvents``` to listen for the ```TERMINATE``` event to ensure that the event has been persisted.
            - Create ```publish``` method to dispatch event in RabbitMQ. 
      - Create ```MessengerAsyncEventBus``` where configure async event bus and send message.
  - ### Recovery data:
    - Todo
# Execution
Create a user storing event when user was created and saving in User MySql table
### Commands:
  - Database container: ```cd docker && make```
  - Create database structure: ```bin/console doctrine:migrations:migrate```
  - Execute project: ```make local```
  - Execute consumer: ```bin/console messenger:consume events -vv```
### Postman
  Import this curl to Postman application and execute:
  ```
  curl  --location --request POST 'https://localhost:8000/signup' \
        --header 'Content-Type: application/json' \
        --form '_name="Victor"' \
        --form '_email="victor@antaivb.com"' \
        --form '_password="password123"'
  ```

